<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResourceCategoryRequest;
use App\Models\Resource\ResourceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ResourceCategoryController extends Controller
{

    public function index()
    {

        $category = ResourceCategory::query()
            ->where('pid', 0)
            ->select('id', 'title as text')
            ->get()
            ->toArray();

        array_unshift($category, ['id' => 0, 'text' => __('最上級')]);

        return view('admin.resource-category.list', compact('category'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $keyword = $request->query('keyword');
        $field = $request->query('field');
        $sort = $request->query('sort');

        $list = ResourceCategory::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->when($field, function ($query) use ($field, $sort) {
                $query->orderBy($field, $sort);
            }, function ($query) {
                $query->orderByDesc('id');
            })
            ->paginate(limit_page());

        $list->append(['parent_text']);

        return $this->responseSuccess($list);
    }

    /**
     * @param ResourceCategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ResourceCategoryRequest $request)
    {
        $user_id = $request->user('admin')->id;
        if (!(($lock = Cache::lock("submit_resource_category_store_lock:$user_id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'pid', 'color', 'status']);

        try {

            $category = new ResourceCategory();
            foreach ($inputs as $field => $value) {
                $category->$field = $value;
            }

            if ($category->save() === false) {
                throw new \Exception('category:failed');
            }

            return $this->responseSuccess([
                'id' => $category->id,
                'title' => $category->title,
                'pid' => $category->pid,
                'status' => $category->status,
            ], __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param ResourceCategoryRequest $request
     * @param ResourceCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ResourceCategoryRequest $request, ResourceCategory $category)
    {
        if (!(($lock = Cache::lock("submit_resource_category_update_lock:$category->id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'pid', 'color', 'status']);

        try {

            foreach ($inputs as $field => $value) {
                $category->$field = $value;
            }

            if ($category->save() === false) {
                throw new \Exception('category:failed');
            }

            return $this->responseSuccess(null, __('修改成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('修改失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param ResourceCategory $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(ResourceCategory $category)
    {
        if (!(($lock = Cache::lock("submit_resource_category_destroy_lock:$category->id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        try {

            $category->delete();

            return $this->responseSuccess(null, __('删除成功'));
        } catch (\Exception $e) {
            throw new ApiException(__('删除失败'), $e->getCode());
        }
    }
}
