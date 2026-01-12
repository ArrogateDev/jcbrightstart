<?php

namespace App\Http\Controllers\Web\Auth;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Services\AppleService;
use Carbon\Carbon;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    public function index()
    {
        return view('web.auth.login');
    }

    /**
     * 登录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleLogin(Request $request)
    {
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_login_lock:$ip", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $email = $request->input('email');
        $password = $request->input('password');
        $remember_me = $request->input('remember_me');
        $redirect = $request->input('redirect', route('user.dashboard.html'));

        if (!$email || !$password) {
            throw new ApiException('The account or password is incorrect', ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
        }

        $user = User::query()->where('email', $email)->firstOr(function () {
            throw new ApiException('The account or password is incorrect', ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
        });

        try {

            if ($user->status !== User::NORMAL) {
                throw new ApiException('The account or password is incorrect', ResponseCode::FORBIDDEN);
            }

            if (!Hash::check($password, $user->password)) {
                throw new ApiException('The account or password is incorrect', ResponseCode::PARAM_ERR);
            }

            Auth::login($user, $remember_me === 'on');

            Auth::logoutOtherDevices($password);

            return $this->responseSuccess(['redirect' => $redirect]);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Login failure', ResponseCode::LOGIN_FAIL);
        }
    }

    /**
     * 谷歌一键登录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleGoogleQuickLogin(Request $request)
    {
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_login_lock:$ip", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $credential = $request->input('credential');
        if (!$credential) {
            throw new ApiException(__('Invalid Parameter'), ResponseCode::PARAM_ERR);
        }
        $redirect = $request->input('redirect', route('user.dashboard.html'));

        try {

            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $result = $client->verifyIdToken($credential);
            if (!$result) {
                throw new ApiException(__('Invalid Parameter'), ResponseCode::PARAM_ERR);
            }
            $exp = $result['exp'];
            if (Carbon::now()->gt(Carbon::createFromTimestamp($exp))) {
                throw new ApiException(__('Invalid Parameter'), ResponseCode::PARAM_ERR);
            }

            $email = $result['email'];
            $first_name = $result['family_name'];
            $last_name = $result['given_name'];
            $user = User::query()->where('email', $email)->firstOrCreate(
                [
                    'email' => $email,
                ], [
                    'full_name' => $first_name . ' ' . $last_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'status' => User::NORMAL
                ]
            );

            if ($user->status !== User::NORMAL) {
                throw new ApiException(__('Account has been disabled.'), ResponseCode::FORBIDDEN);
            }

            Auth::login($user);

            return $this->responseSuccess(['redirect' => $redirect]);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Login failure', ResponseCode::LOGIN_FAIL);
        }
    }

    /**
     * 苹果一键登录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleAppleQuickLogin(Request $request, AppleService $apple_service)
    {
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_login_lock:$ip", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $code = $request->input('code');
        $id_token = $request->input('id_token');
        $raw_user = $request->input('user');
        $state = $request->input('state');
        $redirect = $request->input('redirect', route('user.dashboard.html'));

        if (!$code && !$id_token) {
            throw new ApiException(__('Invalid Parameter'), ResponseCode::PARAM_ERR);
        }

        if ($state && $state !== $request->session()->token()) {
            throw new ApiException(__('Invalid Parameter'), ResponseCode::PARAM_ERR);
        }

        try {

            if ($code) {
                $token_response = $apple_service->exchangeCode($code);
                $id_token = $token_response['id_token'] ?? $id_token;
            }

            if (!$id_token) {
                throw new ApiException(__('Invalid Parameter'), ResponseCode::PARAM_ERR);
            }

            $claims = $apple_service->verifyIdToken($id_token);
            $user_info = [];
            if ($raw_user) {
                $user_info = json_decode($raw_user, true, 512, JSON_THROW_ON_ERROR);
            }

            $email = $claims['email'] ?? Arr::get($user_info, 'email');
            if (!$email) {
                throw new ApiException(__('Invalid Parameter'), ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
            }

            $first_name = Arr::get($user_info, 'name.firstName', '');
            $last_name = Arr::get($user_info, 'name.lastName', '');
            $full_name = trim($first_name . ' ' . $last_name);

            if (!$full_name) {
                $full_name = $claims['name'] ?? $email;
            }

            $user = User::query()->where('email', $email)->firstOrCreate(
                [
                    'email' => $email,
                ], [
                    'full_name' => $full_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'status' => User::NORMAL
                ]
            );

            if ($user->status !== User::NORMAL) {
                throw new ApiException(__('Account has been disabled.'), ResponseCode::FORBIDDEN);
            }

            Auth::login($user);

            return $this->responseSuccess(['redirect' => $redirect]);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Login failure', ResponseCode::LOGIN_FAIL);
        }
    }
}
