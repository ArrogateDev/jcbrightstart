<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InstructRequest;
use App\Models\Base;
use App\Models\Instruct;
use App\Models\Manage\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class InstructController extends Controller
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

        $list = Instruct::query()
            ->when($model, function ($query) use ($model) {
                $query->where('model', $model);
            })
            ->when($environment, function ($query) use ($environment) {
                $query->where('environment', $environment);
            })
            ->select('id', 'model', 'environment', 'instruct')
            ->paginate(limit_page());

        $list->append(['model_text', 'environment_text']);

        return $this->responseSuccess($list);
    }

    /**
     * 修改
     *
     * @param InstructRequest $request
     * @param Instruct $instruct
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InstructRequest $request, Instruct $instruct)
    {
        if (!(($lock = Cache::lock("submit_instruct_update_lock:$instruct->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['instruct']);

        try {

            foreach ($inputs as $field => $value) {
                $instruct->$field = $value;
            }

            if ($instruct->save() === false) {
                throw new \Exception('instruct:failed');
            }

            return $this->responseSuccess(null, __('修改成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('修改失败'), ResponseCode::SERVER_ERR);
        }
    }
}
