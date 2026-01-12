<?php

namespace App\Http\Controllers\Web\Auth;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{

    public function index()
    {
        return view('web.auth.reset-password');
    }

    /**
     * 重置密码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleResetPassword(Request $request)
    {
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_reset_password_lock:$ip", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        if (!$request->hasValidSignature()) {
            throw new ApiException('Invalid request,Link expired!', ResponseCode::PARAM_ERR);
        }

        $email = $request->input('email');
        $inputs = $request->only(['password', 'password_confirmation']);
        $validator = Validator::make($inputs, [
            'password' => 'bail|required|confirmed',
            'password_confirmation' => 'bail|required',
        ]);

        if ($validator->fails()) {
            throw new ApiException($validator->errors()->first(), ResponseCode::PARAM_ERR);
        }

        try {

            $user = User::query()->where('email', $email)->firstOr(function () {
                throw new ApiException('Sorry, we could not locate an account associated with this email address', ResponseCode::USER_DOES_NOT_EXIST);
            });

            $user->password = $inputs['password'];
            if ($user->save() === false) {
                throw new \Exception('user:failed');
            }

            return $this->responseSuccess();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
