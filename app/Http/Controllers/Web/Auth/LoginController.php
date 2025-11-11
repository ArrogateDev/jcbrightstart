<?php

namespace App\Http\Controllers\Web\Auth;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Google_Client;
use Illuminate\Http\Request;
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
        $redirect = $request->input('redirect', '/');

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
            throw new ApiException(__('Invalid Parameter'), ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
        }
        $redirect = $request->input('redirect', '/');

        try {

            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $result = $client->verifyIdToken($credential);
            if (!$result) {
                throw new ApiException(__('Invalid Parameter'), ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
            }
            $exp = $result['exp'];
            if (Carbon::now()->gt(Carbon::createFromTimestamp($exp))) {
                throw new ApiException(__('Invalid Parameter'), ResponseCode::ACCOUNT_OR_PASSWORD_ERROR);
            }

            $email = $result['email'];
            $full_name = $result['name'];
            $first_name = $result['family_name'];
            $last_name = $result['given_name'];
            $user = User::query()->where('email', $email)->firstOrCreate(
                [
                    'email' => $email,
                ], [
                    'full_name' => $full_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name
                ]
            );

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
    public function handleAppleQuickLogin(Request $request)
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
        $redirect = $request->input('redirect', '/');

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


}
