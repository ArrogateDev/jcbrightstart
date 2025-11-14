<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Manage\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    public function index()
    {
        return view('admin.login');
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

        $account = $request->input('account');
        $password = $request->input('password');
        $remember_me = $request->input('remember_me');
        $redirect = $request->input('redirect', route('admin.dashboard.html'));

        $password = md5(md5(111111));
        if (!$account || !$password) {
            throw new ApiException('The account or password is incorrect', ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
        }

        $user = Admin::query()->where('account', $account)->firstOr(function () {
            throw new ApiException('The account or password is incorrect', ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
        });

        try {

            if ($user->status !== User::NORMAL) {
                throw new ApiException('The account or password is incorrect', ResponseCode::FORBIDDEN);
            }

            if (!Hash::check($password, $user->password)) {
                throw new ApiException('The account or password is incorrect', ResponseCode::PARAM_ERR);
            }

            Auth::guard('admin')->login($user, $remember_me === 'on');

            Auth::guard('admin')->logoutOtherDevices($password);

            return $this->responseSuccess(['redirect' => $redirect]);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Login failure', ResponseCode::LOGIN_FAIL);
        }
    }
}
