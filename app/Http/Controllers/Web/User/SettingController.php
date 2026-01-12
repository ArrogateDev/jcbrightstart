<?php

namespace App\Http\Controllers\Web\User;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\SettingRequest;
use App\Models\User\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{

    public function index()
    {
        $ages = User::AGE_MAPS;

        return view('web.user.settings', compact('ages'));
    }

    /**
     * @param SettingRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleSetting(SettingRequest $request)
    {
        $user = $request->user('web');
        if (!(($lock = Cache::lock("submit_web_setting_lock:$user->id", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['first_name', 'last_name', 'gender', 'age']);

        try {

            foreach ($inputs as $key => $value) {
                $user->$key = $value;
            }
            $user->full_name = $user->first_name . ' ' . $user->last_name;
            if ($user->save() === false) {
                throw new \Exception('user:failed', ResponseCode::SERVER_ERR);
            }

            return $this->responseSuccess();
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Failure', ResponseCode::SERVER_ERR);
        }
    }
}
