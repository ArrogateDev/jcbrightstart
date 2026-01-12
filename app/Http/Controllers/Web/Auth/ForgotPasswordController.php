<?php

namespace App\Http\Controllers\Web\Auth;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Mail\UserForgotPasswordMail;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{

    public function index()
    {
        return view('web.auth.forgot-password');
    }

    /**
     * 忘记密码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleForgotPassword(Request $request)
    {
        $user = $request->user('web');
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_forgot_password_lock:" . ($user->id ?? $ip), 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        if (!$user) {
            $inputs = $request->only(['email']);
            $validator = Validator::make($inputs, [
                'email' => 'bail|required|email',
            ], [
                'email.required' => 'Email is required',
                'email.email' => 'Invalid email address',
            ]);

            if ($validator->fails()) {
                throw new ApiException($validator->errors()->first(), ResponseCode::PARAM_ERR);
            }
        }

        try {

            !$user && $user = User::query()->where('email', $inputs['email'])->firstOr(function () {
                throw new ApiException('Sorry, we could not locate an account associated with this email address', ResponseCode::USER_DOES_NOT_EXIST);
            });

            Mail::to($user)->send(new UserForgotPasswordMail($user));

            return $this->responseSuccess();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
