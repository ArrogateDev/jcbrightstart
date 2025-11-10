<?php

namespace App\Http\Controllers\Api;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\QuickLoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Models\UserGeminiLog;
use App\Models\UserInfo;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * 登录
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function login(LoginRequest $request)
    {
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_login_lock:$ip", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');

        $user = User::query()
            ->when($email, function ($query) use ($email) {
                $query->where('email', $email);
            })
            ->when($phone, function ($query) use ($phone) {
                $query->where('phone', $phone);
            })
            ->firstOr(function () {
                throw new ApiException('賬號或者密碼錯誤', ResponseCode::PARAM_ERR);
            });

        try {

            if ($user->status !== User::NORMAL) {
                throw new ApiException('賬號已禁用', ResponseCode::FORBIDDEN);
            }

            if (!Hash::check($password, $user->password)) {
                throw new ApiException('賬號或者密碼錯誤', ResponseCode::PARAM_ERR);
            }

            $user->makeHidden(['status', 'created_at', 'updated_at']);

            $user->remove_tokens('user');
            $token = $user->createToken(env('APP_NAME'), ['user']);

            $result = [
                'token' => 'Bearer ' . $token->plainTextToken,
            ];

            return $this->responseSuccess($result);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('登錄失敗', ResponseCode::LOGIN_FAIL);
        }
    }

    /**
     * 快捷登录
     *
     * @param QuickLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleQuickLogin(QuickLoginRequest $request)
    {
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_quick_login_lock:$ip", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $email = $request->input('email');
        $password = $request->input('password');
        $data = $request->input('data');
        $info_string = [$password, ...$data];
        $info_string = implode('', $info_string);

        $key = 'Arrogate20258888';
        $iv = 'ArrogateIV202566';
        $decrypted = $this->handleAesDecrypt($info_string, $key, $iv);
        if (!$decrypted) {
            throw new ApiException('信息錯誤', ResponseCode::PARAM_ERR);
        }
        $info = json_decode($decrypted, true);
        if ($email !== ($info['email'] ?? '')) {
            throw new ApiException('信息錯誤', ResponseCode::PARAM_ERR);
        }

        $user = User::query()
            ->when($email, function ($query) use ($email) {
                $query->where('email', $email);
            })
            ->firstOrCreate(
                [
                    'email' => $email,
                ],
                [
                    'google_openid' => $info['openid'],
                ]
            );

        $is_new = $user->wasRecentlyCreated;

        $user->refresh();
        if ($user->status !== User::NORMAL) {
            throw new ApiException('賬號已禁用', ResponseCode::FORBIDDEN);
        }

        try {

            $is_new && DB::beginTransaction();

            if (!$user->google_openid) {
                $user->google_openid = $info['openid'];
                if ($user->save() === false) {
                    throw new \Exception('user:failed');
                }
            }

            $user->makeHidden(['status', 'created_at', 'updated_at']);

            $user->remove_tokens('user');
            $token = $user->createToken(env('APP_NAME'), ['user']);

            $result = [
                'token' => 'Bearer ' . $token->plainTextToken,
            ];

            if ($is_new) {
                $num = 100;

                UserGeminiLog::IncreaseLog($user->id, $num, UserGeminiLog::TYPE_REGISTRATION_BONUS);

                $user_info = UserInfo::init($user->id);
                $user_info->total_num = $num;
                $user_info->usable_num = $num;
                if ($user_info->save() === false) {
                    throw new \Exception('user_info:failed');
                }

                $result['usable_num'] = $user_info->usable_num;

                DB::commit();
            }

            return $this->responseSuccess($result);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            $is_new && DB::rollBack();
            Log::error($e);
            throw new ApiException('登錄失敗', ResponseCode::LOGIN_FAIL);
        }
    }

    /**
     * 注册
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function register(RegisterRequest $request)
    {
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_register_lock:$ip", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');
        $code = $request->input('code');

        $ver_code = VerificationCode::check($phone ?? $email, 'register', $code);

        try {

            DB::beginTransaction();

            $user = new User();
            $email && $user->email = $email;
            $phone && $user->phone = $phone;
            $user->password = $password;
            if ($user->save() === false) {
                throw new \Exception('user:failed');
            }

            $user->makeHidden(['status', 'created_at', 'updated_at']);

            $user->remove_tokens('user');
            $token = $user->createToken(env('APP_NAME'), ['user']);

            $result = [
                'token' => 'Bearer ' . $token->plainTextToken,
            ];

            $ver_code->used();

            $num = 100;

            UserGeminiLog::IncreaseLog($user->id, $num, UserGeminiLog::TYPE_REGISTRATION_BONUS);

            $user_info = UserInfo::init($user->id);
            $user_info->total_num = $num;
            $user_info->usable_num = $num;
            if ($user_info->save() === false) {
                throw new \Exception('user_info:failed');
            }

            $result['usable_num'] = $user_info->usable_num;

            DB::commit();

            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException('註冊失敗', ResponseCode::LOGIN_FAIL);
        }
    }

    /**
     * 忘记密码
     *
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleForgotPassword(ForgotPasswordRequest $request)
    {
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_forgot_password_lock:$ip", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');
        $code = $request->input('code');

        $ver_code = VerificationCode::check($phone ?? $email, 'forgot_password', $code);

        $user = User::query()
            ->when($email, function ($query) use ($email) {
                $query->where('email', $email);
            })
            ->when($phone, function ($query) use ($phone) {
                $query->where('phone', $phone);
            })
            ->firstOr(function () {
                throw new ApiException('賬號或者密碼錯誤', ResponseCode::PARAM_ERR);
            });

        try {

            DB::beginTransaction();

            $user->password = $password;
            if ($user->save() === false) {
                throw new \Exception('user:failed');
            }

            $user->makeHidden(['status', 'created_at', 'updated_at']);

            $user->remove_tokens('user');
            $token = $user->createToken(env('APP_NAME'), ['user']);

            $result = [
                'token' => 'Bearer ' . $token->plainTextToken,
            ];

            $ver_code->used();

            DB::commit();

            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException('失敗', ResponseCode::LOGIN_FAIL);
        }
    }

    /**
     * 退出登录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user('user');
        $user->remove_tokens('user');

        return $this->responseSuccess(null, '退出成功');
    }

    /**
     * @param $data
     * @param $key
     * @param $iv
     * @return false|string
     */
    private function handleAesDecrypt($data, $key, $iv)
    {
        $key = substr($key, 0, 16);
        $iv = substr($iv, 0, 16);

        try {
            $decrypted = openssl_decrypt(
                hex2bin($data),
                'AES-128-CBC',
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );

            return $decrypted ?: false;
        } catch (\Exception $e) {
            Log::error('AES decryption failed: ' . $e->getMessage());
            return false;
        }
    }
}
