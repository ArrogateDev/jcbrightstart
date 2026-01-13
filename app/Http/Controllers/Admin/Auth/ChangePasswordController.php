<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ChangePasswordController extends Controller
{

    public function index()
    {
        return view('admin.change-password');
    }

    /**
     * 修改密码
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleChangePassword(ChangePasswordRequest $request)
    {
        $user = $request->user('admin');
        if (!(($lock = Cache::lock("submit_change_password_lock:$user->id", 30))->get())) {
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $current_password = $request->input('current_password');
        $password = $request->input('password');

        if (!Hash::check($current_password, $user->password)) {
            throw new ApiException(__('当前密码错误'), ResponseCode::PARAM_ERR);
        }

        try {

            $user->password = $password;
            if ($user->save() === false) {
                throw new \Exception('user:failed');
            }

            return $this->responseSuccess();
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('修改密码失败'), ResponseCode::SERVER_ERR);
        }
    }
}
