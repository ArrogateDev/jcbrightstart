<?php

namespace App\Http\Controllers\Web;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\VerificationCodeRequest;
use App\Mail\VerificationCodeMail;
use App\Models\User\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerificationCodeController extends Controller
{
    /**
     * 获取验证码
     *
     * @param VerificationCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function getCode(VerificationCodeRequest $request)
    {
        $ip = $request->ip();
        if (!(($lock = Cache::lock("submit_get_code_lock:$ip", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $email = $request->input('email');
        $scene = (string)$request->input('scene', 'register');


        $is_exists = User::query()
            ->when($email, function ($query) use ($email) {
                $query->where('email', $email);
            })
            ->exists();

        if ($scene === 'register' && $is_exists) {
            throw new ApiException(__('電郵地址已註冊'), ResponseCode::PARAM_ERR);
        }

        if ($scene === 'forgot_password' && !$is_exists) {
            throw new ApiException(__('賬號不存在'), ResponseCode::PARAM_ERR);
        }

        $environment = app()->environment(['production']);
        if (!in_array($scene, ['register', 'forgot_password'])) {
            throw new ApiException(__('参数错误'), ResponseCode::PARAM_ERR);
        }

        $status_query = VerificationCode::query()
            ->when($email, function ($query) use ($email) {
                $query->where('account', $email);
            });

        $today = Carbon::now()->toDateString();
        if ($environment && (clone $status_query)->where(['used' => 0, 'scene' => 'register'])->count() > 10) {
            throw new ApiException(__('長期獲取驗證碼未使用已禁用!'), ResponseCode::FORBIDDEN);
        }

        if ($environment && VerificationCode::query()->where(['ip' => $ip, 'status' => 1])->whereDate('created_at', $today)->count() > 10) {
            throw new ApiException(__('发送数量已达上限!'), ResponseCode::FORBIDDEN);
        }

        if ($environment && (clone $status_query)->whereDate('created_at', $today)->count() > 10) {
            throw new ApiException(__('發送數量已達上限!!'), ResponseCode::FORBIDDEN);
        }

        try {

            DB::beginTransaction();

            $code = $environment ? mt_rand(100000, 999999) : 123456;

            $log = new VerificationCode();
            $log->account = $email;
            $log->code = $code;
            $log->scene = $scene;
            $log->status = 1;
            $log->used = 0;
            $log->ip = $ip;
            $log->message = 'ok';
            if ($log->save() === false) {
                throw new \Exception('failed', ResponseCode::FORBIDDEN);
            }

            VerificationCode::query()->where(['account' => $email, 'scene' => $scene, 'status' => 1])->update(['status' => 0]);

            DB::commit();

            Mail::to($log->account)->queue(new VerificationCodeMail($log));

            return $this->responseSuccess(null, __('发送成功'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e);
            $log->status = 0;
            $log->message = $e->getMessage();
            $log->save();
            throw new ApiException(__('发送失败'), ResponseCode::FORBIDDEN);
        }
    }
}
