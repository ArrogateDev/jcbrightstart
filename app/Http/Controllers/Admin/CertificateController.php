<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CertificateRequest;
use App\Models\Certificate;
use App\Tools\FileTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    /**
     * 证书列表页
     */
    public function index()
    {
        return view('admin.certificate.list');
    }

    /**
     * 证书列表
     */
    public function list(Request $request)
    {
        $keyword = $request->query('keyword');

        $list = Certificate::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->paginate(limit_page());

        return $this->responseSuccess($list);
    }

    /**
     * @param CertificateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function store(CertificateRequest $request)
    {
        $user_id = $request->user('admin')->id;
        if (!(($lock = Cache::lock("submit_certificate_store_lock:$user_id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['name', 'name_config', 'date_config', 'width', 'height']);

        try {

            $file_path = FileTool::existsAndMake('certificates');

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $file_name = uniqid() . '.' . $extension;
            Storage::putFileAs($file_path, $file, $file_name);

            $certificate = new Certificate();
            foreach ($inputs as $key => $value) {
                $certificate->$key = $value;
            }
            $certificate->path = $file_path . $file_name;
            if ($certificate->save() === false) {
                throw new \Exception('certificate:failed', ResponseCode::SERVER_ERR);
            }

            return $this->responseSuccess(['id' => $certificate->id, 'title' => $certificate->name], __('成功'));
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param CertificateRequest $request
     * @param Certificate $certificate
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function update(CertificateRequest $request, Certificate $certificate)
    {
        if (!(($lock = Cache::lock("submit_certificate_update_lock:$certificate->id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['name', 'name_config', 'date_config', 'width', 'height']);

        try {

            $file = $request->file('image');
            if ($file) {
                $file_path = FileTool::existsAndMake('certificates');
                $extension = $file->getClientOriginalExtension();
                $file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($file_path, $file, $file_name);

                $old_path = $certificate->getRawOriginal('path');
                FileTool::existsAnddelete($old_path);

                $certificate->path = $file_path . $file_name;
            }

            foreach ($inputs as $key => $value) {
                $certificate->$key = $value;
            }
            if ($certificate->save() === false) {
                throw new \Exception('certificate:failed', ResponseCode::SERVER_ERR);
            }

            return $this->responseSuccess(null, __('成功'));
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Certificate $certificate
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function destroy(Certificate $certificate)
    {
        if (!(($lock = Cache::lock("submit_certificate_destroy_lock:$certificate->id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        try {

            $old_path = $certificate->getRawOriginal('path');
            FileTool::existsAnddelete($old_path);

            $certificate->delete();

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }
}
