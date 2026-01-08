<?php

namespace App\Http\Controllers\Admin\News;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsCategoryRequest;
use App\Models\News\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NewsCategoryController extends Controller
{

    public function index()
    {
        return view('admin.news-category.list');
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

        $list = NewsCategory::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->when($field, function ($query) use ($field, $sort) {
                $query->orderBy($field, $sort);
            }, function ($query) {
                $query->orderBy('id');
            })
            ->paginate(limit_page());

        return $this->responseSuccess($list);
    }

    /**
     * @param NewsCategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NewsCategoryRequest $request)
    {
        $user_id = $request->user('admin')->id;
        if (!(($lock = Cache::lock("submit_news_category_store_lock:$user_id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'is_nav', 'status']);

        try {

            $category = new NewsCategory();
            foreach ($inputs as $field => $value) {
                $category->$field = $value;
            }

            if ($category->save() === false) {
                throw new \Exception('category:failed');
            }

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param NewsCategoryRequest $request
     * @param NewsCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NewsCategoryRequest $request, NewsCategory $category)
    {
        if (!(($lock = Cache::lock("submit_news_category_update_lock:$category->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'is_nav', 'status']);

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
     * @param NewsCategory $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(NewsCategory $category)
    {
        if (!(($lock = Cache::lock("submit_news_category_destroy_lock:$category->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
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
