<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResourceRequest;
use App\Models\Resource\Resource;
use App\Models\Resource\ResourceCategory;
use App\Tools\FileTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ResourceController extends Controller
{

    public function index()
    {
        return view('admin.resource.list');
    }

    public function view(Resource $resource)
    {
        $resource->load('category:id,title');

        $categories = ResourceCategory::query()
            ->select('id as value', 'title as label', 'pid')
            ->get()
            ->toArray();
        $categories = list_to_tree($categories, 0, 'children', 'value');

        return view('admin.resource.new', ['resource' => $resource, 'categories' => $categories]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $keyword = $request->query('keyword');
        $status = $request->query('status');
        $field = $request->query('field');
        $sort = $request->query('sort');

        $list = Resource::query()
            ->with('category:id,title')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($field, function ($query) use ($field, $sort) {
                $query->orderBy($field, $sort);
            }, function ($query) {
                $query->orderByDesc('sort')->orderByDesc('id');
            })
            ->select('id', 'title', 'thumbnail', 'category_id', 'type', 'sort', 'status', 'created_at')
            ->paginate(limit_page());

        $list->map(function ($item) {
            $item->url = route('admin.resource.update.view.html', ['resource' => $item->id]);
        });

        $list->append(['category_text']);

        return $this->responseSuccess($list);
    }

    /**
     * @param ResourceRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function store(ResourceRequest $request)
    {
        $user_id = $request->user('admin')->id;
        if (!(($lock = Cache::lock("submit_resource_store_lock:$user_id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'type', 'category_id', 'thumbnail_show', 'short', 'description', 'sort', 'status']);

        try {

            $file = $request->file('thumbnail');
            $pdf_file = $request->file('pdf_file');
            $video = $request->input('video');

            DB::beginTransaction();

            $resource = new Resource();
            foreach ($inputs as $key => $value) {
                $resource->$key = $value;
            }

            if ($file) {
                $file_path = FileTool::existsAndMake('resource');
                $extension = $file->getClientOriginalExtension();
                $file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($file_path, $file, $file_name);
                $resource->thumbnail = $file_path . $file_name;
            }

            if ($pdf_file) {
                $pdf_file_path = FileTool::existsAndMake('resource');
                $extension = $pdf_file->getClientOriginalExtension();
                $pdf_file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($pdf_file_path, $pdf_file, $pdf_file_name);
                $resource->pdf = $pdf_file_path . $pdf_file_name;
            }

            if ($resource->category_id === 0) {
                $resource->category_id = $resource->category_top_id;
            }

            $category = ResourceCategory::find($resource->category_id);
            $ancestors = $category->getAncestors(true);

            $category_ids = $ancestors->pluck('id')->toArray();
            if (!empty($category_ids)) {
                $resource->categories()->sync($category_ids);
            }

            if ($resource->type == Resource::TYPE_VIDEO && $video) {
                $resource->short = $video;
            }

            if ($resource->save() === false) {
                throw new \Exception('resource:failed', ResponseCode::SERVER_ERR);
            }

            DB::commit();

            return $this->responseSuccess(['id' => $resource->id], __('成功'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param ResourceRequest $request
     * @param Resource $resource
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function update(ResourceRequest $request, Resource $resource)
    {
        if (!(($lock = Cache::lock("submit_resource_update_lock:$resource->id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'type', 'category_top_id', 'category_id', 'thumbnail_show', 'short', 'description', 'sort', 'status']);

        try {

            DB::beginTransaction();

            $file = $request->file('thumbnail');
            $pdf_file = $request->file('pdf_file');
            $video = $request->input('video');

            if ($file) {
                $file_path = FileTool::existsAndMake('resource');
                $extension = $file->getClientOriginalExtension();
                $file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($file_path, $file, $file_name);

                $old_path = $resource->getRawOriginal('thumbnail');
                FileTool::existsAnddelete($old_path);

                $resource->thumbnail = $file_path . $file_name;
            }

            if ($pdf_file) {
                $pdf_file_path = FileTool::existsAndMake('resource');
                $extension = $pdf_file->getClientOriginalExtension();
                $pdf_file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($pdf_file_path, $pdf_file, $pdf_file_name);

                $old_file_path = $resource->getRawOriginal('pdf');
                FileTool::existsAnddelete($old_file_path);

                $resource->pdf = $pdf_file_path . $pdf_file_name;
            }

            foreach ($inputs as $key => $value) {
                $resource->$key = $value;
            }

            if ($resource->type == Resource::TYPE_VIDEO && $video) {
                $resource->short = $video;
            }

            if ($resource->category_id === 0) {
                $resource->category_id = $resource->category_top_id;
            }

            $category = ResourceCategory::find($resource->category_id);
            $ancestors = $category->getAncestors(true);

            $category_ids = $ancestors->pluck('id')->toArray();
            if (!empty($category_ids)) {
                $resource->categories()->sync($category_ids);
            }

            if ($resource->save() === false) {
                throw new \Exception('resource:failed', ResponseCode::SERVER_ERR);
            }

            DB::commit();

            return $this->responseSuccess(['id' => $resource->id], __('成功'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Request $request
     * @param Resource $resource
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function status(Request $request, Resource $resource)
    {
        if (!(($lock = Cache::lock("submit_resource_status_lock:$resource->id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $status = (int)$request->input('status');

        if ($status === Resource::STATUS_PUBLISHED) {

            $validator = Validator::make($resource->toArray(), [
                'title' => 'bail|required',
                'thumbnail' => 'bail|required',
                'category_id' => 'bail|required|exists:resource_categories,id',
                'short' => 'bail|required',
                'description' => 'bail|required'
            ]);

            if ($validator->fails()) {
                throw new ApiException($validator->errors()->first(), ResponseCode::PARAM_ERR);
            }
        }

        try {

            $resource->status = $status;
            if ($resource->save() === false) {
                throw new \Exception('resource:failed', ResponseCode::SERVER_ERR);
            }

            return $this->responseSuccess(0, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Resource $resource
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function destroy(Resource $resource)
    {
        if (!(($lock = Cache::lock("submit_resource_destroy_lock:$resource->id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        try {

            $old_path = $resource->getRawOriginal('thumbnail');
            FileTool::existsAnddelete($old_path);

            $resource->delete();

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }
}
