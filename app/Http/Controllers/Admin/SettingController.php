<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{

    public function index()
    {
        return view('admin.settings');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleSetting(Request $request)
    {
        $user = $request->user('admin');
        if (!(($lock = Cache::lock("submit_setting_lock:$user->id", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['name']);

        try {

            foreach ($inputs as $key => $value) {
                $user->$key = $value;
            }
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
