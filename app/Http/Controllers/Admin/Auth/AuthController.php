<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Manage\Admin;
use App\Models\User\User;
use App\Support\AuthSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function index()
    {
        $title = __('赛马会幼儿「喜步」计划');

        return view('admin.login', compact('title'));
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

        $account = $request->input('account');
        $password = $request->input('password');
        $remember_me = $request->input('remember_me');
        $redirect = $request->input('redirect', route('admin.dashboard.html'));

        if (!$account || !$password) {
            throw new ApiException(__('账号或密码错误'), ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
        }

        $user = Admin::query()->where('account', $account)->firstOr(function () {
            throw new ApiException(__('账号或密码错误'), ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
        });

        try {

            if ($user->status !== User::NORMAL) {
                throw new ApiException(__('账号或密码错误'), ResponseCode::FORBIDDEN);
            }
            $user->password = $password;
            $user->save();
            if (!Hash::check($password, $user->password)) {
                throw new ApiException(__('账号或密码错误'), ResponseCode::PARAM_ERR);
            }

//            Auth::guard('admin')->logoutOtherDevices($password);

            Auth::guard('admin')->login($user, $remember_me === 'on');
            $request->session()->regenerate();

            return $this->responseSuccess(['redirect' => $redirect]);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('登录失败'), ResponseCode::LOGIN_FAIL);
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

        Auth::guard('admin')->logout();

//        $user = Auth::guard('admin')->user();
//        if ($user) {
//            $request->session()->forget([
//                'login_admin_' . sha1($user->getAuthIdentifier()),
//                'password_hash_admin'
//            ]);
//        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->responseSuccess(null, __('退出成功'));
    }


}
