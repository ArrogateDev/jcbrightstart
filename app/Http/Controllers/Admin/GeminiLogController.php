<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InstructRequest;
use App\Models\Base;
use App\Models\GeminiLog;
use App\Models\Instruct;
use App\Models\Manage\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeminiLogController extends Controller
{
    /**
     * 列表
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $model = $request->query('model');
        $environment = $request->query('environment');

        $list = GeminiLog::query()
//            ->when($model, function ($query) use ($model) {
//                $query->where('model', $model);
//            })
//            ->when($environment, function ($query) use ($environment) {
//                $query->where('environment', $environment);
//            })
            ->orderByDesc('id')
//            ->select('id', 'model', 'environment', 'instruct')
            ->paginate(limit_page());

        $list->append(['model_text', 'lang_text', 'environment_text', 'status_text']);

        return $this->responseSuccess($list);
    }

    /**
     * 删除
     *
     * @param GeminiLog $log
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(GeminiLog $log)
    {
        if (!(($lock = Cache::lock("submit_log_destroy_lock:$log->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });


        try {

            $log->delete();

            return $this->responseSuccess(null, __('删除成功'));
        } catch (\Exception $e) {
            throw new ApiException(__('删除失败'), $e->getCode());
        }
    }
}
