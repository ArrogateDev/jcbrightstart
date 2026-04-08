<?php

namespace App\Http\Controllers\Web\Auth;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\VerificationCode;
use App\Services\AppleService;
use Carbon\Carbon;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Support\AuthSession;

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
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
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
            throw new ApiException(__('账号或密码错误'), ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
        }

        $user = User::query()->where('email', $email)->firstOr(function () {
            throw new ApiException(__('账号或密码错误'), ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
        });

        try {

            if ($user->status !== User::NORMAL) {
                throw new ApiException(__('账号或密码错误'), ResponseCode::FORBIDDEN);
            }

            if (!Hash::check($password, $user->password)) {
                throw new ApiException(__('账号或密码错误'), ResponseCode::PARAM_ERR);
            }

            Auth::guard('web')->login($user, $remember_me === 'on');

            Auth::guard('web')->logoutOtherDevices($password);

            return $this->responseSuccess(['redirect' => $redirect]);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('登录失败'), ResponseCode::LOGIN_FAIL);
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
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $credential = $request->input('credential');
        if (!$credential) {
            throw new ApiException(__('参数无效'), ResponseCode::PARAM_ERR);
        }
        $redirect = $request->input('redirect', route('user.dashboard.html'));

        try {

            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $result = $client->verifyIdToken($credential);
            if (!$result) {
                throw new ApiException(__('参数无效'), ResponseCode::PARAM_ERR);
            }

            $exp = $result['exp'];
            if (Carbon::now()->gt(Carbon::createFromTimestamp($exp))) {
                throw new ApiException(__('参数无效'), ResponseCode::PARAM_ERR);
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
                throw new ApiException(__('账号已被禁用'), ResponseCode::FORBIDDEN);
            }

            Auth::guard('web')->login($user);

            return $this->responseSuccess(['redirect' => $redirect]);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('登录失败'), ResponseCode::LOGIN_FAIL);
        }
    }

    private const APPLE_PENDING_CACHE_PREFIX = 'apple_pending:';
    private const APPLE_PENDING_TTL = 600; // 10 分钟

    /**
     * 苹果一键登录：先根据 apple_id 查账号，存在则直接登录；不存在则返回 need_choice，由前端弹窗让用户选择绑定或新建
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleAppleQuickLogin(Request $request, AppleService $apple_service)
    {
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_login_lock:$ip", 30))->get())) {
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $action = $request->input('action'); // null | 'create' | 'bind'
        $redirect = $request->input('redirect', route('user.dashboard.html'));

        if ($action === 'create') {
            return $this->handleAppleQuickCreate($request, $redirect);
        }

        if ($action === 'bind') {
            return $this->handleAppleQuickBind($request, $redirect);
        }

        // 首次：验证 Apple 凭据，按 apple_id 查用户
        $code = $request->input('code');
        $id_token = $request->input('id_token');
        $raw_user = $request->input('user');
        $state = $request->input('state');

        if (!$code && !$id_token) {
            throw new ApiException(__('参数无效'), ResponseCode::PARAM_ERR);
        }

        if ($state && $state !== $request->session()->token()) {
            throw new ApiException(__('参数无效'), ResponseCode::PARAM_ERR);
        }

        try {

            if ($code) {
                $token_response = $apple_service->exchangeCode($code);
                $id_token = $token_response['id_token'] ?? $id_token;
            }

            if (!$id_token) {
                throw new ApiException(__('参数无效'), ResponseCode::PARAM_ERR);
            }

            $claims = $apple_service->verifyIdToken($id_token);
            $user_info = is_array($raw_user) ? $raw_user : (is_string($raw_user) ? (json_decode($raw_user, true) ?: []) : []);
            $apple_id = $claims['sub'] ?? null;
            if (!$apple_id) {
                throw new ApiException(__('无法获取苹果用户标识'), ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
            }

            $email = $claims['email'] ?? Arr::get($user_info, 'email');
            if (!$email) {
                throw new ApiException(__('无法获取邮箱信息'), ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
            }

            $is_email_hidden = isset($claims['is_private_email']) ? (bool)$claims['is_private_email'] : false;
            if ($is_email_hidden && !empty($user_info['email'])) {
                $email = $user_info['email'];
            }

            $first_name = Arr::get($user_info, 'name.firstName', '');
            $last_name = Arr::get($user_info, 'name.lastName', '');
            $full_name = trim($first_name . ' ' . $last_name) ?: ($claims['name'] ?? $email);

            $result = [];

            if ($is_email_hidden) {
                // 私有邮箱：仅用 apple_id 查
                $user = User::query()->where('apple_id', $apple_id)->first();
            } else {
                // 非私有邮箱：仅用邮箱查；未绑定苹果 id 则自动绑定并登录
                $user = User::query()->where('email', $email)->first();
            }

            if ($user) {

                if ($user->status !== User::NORMAL) {
                    throw new ApiException(__('账号已被禁用'), ResponseCode::FORBIDDEN);
                }

                if (empty($user->apple_id)) {
                    $user->apple_id = $apple_id;
                    $user->save();
                }

                Auth::guard('web')->login($user);

                $result['redirect'] = $redirect;
            } else {

                // 未找到：写入临时缓存，返回 need_choice + apple_pending_token
                $pending_token = \Illuminate\Support\Str::random(64);
                $cache_key = self::APPLE_PENDING_CACHE_PREFIX . $pending_token;
                Cache::put($cache_key, [
                    'apple_id' => $apple_id,
                    'email' => $email,
                    'full_name' => $full_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'is_private_email' => $is_email_hidden ? 1 : 0,
                ], self::APPLE_PENDING_TTL);

                $result['need_choice'] = true;
                $result['apple_pending_token'] = $pending_token;
                $result['email'] = $email;
            }

            return $this->responseSuccess($result);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('登录失败'), ResponseCode::LOGIN_FAIL);
        }
    }

    /**
     * 苹果快捷登录 - 新建账号
     */
    protected function handleAppleQuickCreate(Request $request, string $redirect): \Illuminate\Http\JsonResponse
    {
        $pending_token = $request->input('apple_pending_token');
        if (!$pending_token) {
            throw new ApiException(__('参数无效'), ResponseCode::PARAM_ERR);
        }

        $cache_key = self::APPLE_PENDING_CACHE_PREFIX . $pending_token;
        $pending = Cache::get($cache_key);
        if (!$pending) {
            throw new ApiException(__('链接已过期，请重新使用 Apple 登录'), ResponseCode::PARAM_ERR);
        }

        try {

            $apple_id = $pending['apple_id'];
            $email = $pending['email'];
            $full_name = $pending['full_name'] ?? '';
            $first_name = $pending['first_name'] ?? '';
            $last_name = $pending['last_name'] ?? '';
            $is_private_email = (int)($pending['is_private_email'] ?? 0);

            $user = User::query()
                ->where('apple_id', $apple_id)
                ->firstOrCreate(
                    [
                        'apple_id' => $apple_id,
                    ],
                    [
                        'email' => $email,
                        'full_name' => $full_name,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'is_private_email' => $is_private_email,
                        'status' => User::NORMAL,
                    ]
                );

            if ($user->status !== User::NORMAL) {
                throw new ApiException(__('账号已被禁用'), ResponseCode::FORBIDDEN);
            }

            Cache::forget($cache_key);
            Auth::guard('web')->login($user);

            return $this->responseSuccess(['redirect' => $redirect]);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('登录失败'), ResponseCode::LOGIN_FAIL);
        }
    }

    /**
     * 苹果快捷登录 - 绑定已有账号
     */
    protected function handleAppleQuickBind(Request $request, string $redirect): \Illuminate\Http\JsonResponse
    {
        $pending_token = $request->input('apple_pending_token');
        $email = $request->input('email');
        $code = $request->input('code');

        if (!$pending_token || !$email || $code === null || $code === '') {
            throw new ApiException(__('请填写邮箱和验证码'), ResponseCode::PARAM_ERR);
        }

        $cache_key = self::APPLE_PENDING_CACHE_PREFIX . $pending_token;
        $pending = Cache::get($cache_key);
        if (!$pending) {
            throw new ApiException(__('链接已过期，请重新使用 Apple 登录'), ResponseCode::PARAM_ERR);
        }

        $ver_code = VerificationCode::check($email, 'bind', trim($code));
        $ver_code->used();

        $user = User::query()->where('email', $email)->first();
        if (!$user) {
            throw new ApiException(__('账号不存在'), ResponseCode::PARAM_ERR);
        }

        if ($user->status !== User::NORMAL) {
            throw new ApiException(__('账号已被禁用'), ResponseCode::FORBIDDEN);
        }

        if ($user->apple_id && $user->apple_id !== $pending['apple_id']) {
            throw new ApiException(__('该账号已绑定其他 Apple ID'), ResponseCode::PARAM_ERR);
        }

        $user->apple_id = $pending['apple_id'];
        if ($user->save() === false) {
            throw new ApiException(__('绑定失败，请重试'), ResponseCode::LOGIN_FAIL);
        }

        Cache::forget($cache_key);
        Auth::guard('web')->login($user);

        return $this->responseSuccess(['redirect' => $redirect]);
    }
}
