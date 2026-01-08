<?php

namespace App\Http\Controllers\Admin\News;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\News\News;
use App\Tools\FileTool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{

    public function index()
    {
        return view('admin.news.list');
    }

    public function view(News $news)
    {
        $news->load('category:id,title');

        return view('admin.news.new', ['news' => $news]);
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

        $list = News::query()
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
                $query->orderBy('id');
            })
            ->paginate(limit_page());

        $list->map(function ($item) {
            $item->url = route('admin.news.update.view.html', ['news' => $item->id]);
        });

        $list->append(['category_text']);

        return $this->responseSuccess($list);
    }

    /**
     * @param NewsRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function store(NewsRequest $request)
    {
        $user_id = $request->user('admin')->id;
        if (!(($lock = Cache::lock("submit_news_store_lock:$user_id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'category_id', 'short', 'start_date', 'end_date', 'description', 'status']);
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');

        try {

            $file = $request->file('thumbnail');

            DB::beginTransaction();

            $news = new News();
            foreach ($inputs as $key => $value) {
                $news->$key = $value;
            }
            $news->start_time = Carbon::createFromFormat('h:i A', $start_time)->format('H:i:s');
            $news->end_time = Carbon::createFromFormat('h:i A', $end_time)->format('H:i:s');

            if ($file) {
                $file_path = FileTool::existsAndMake('news');
                $extension = $file->getClientOriginalExtension();
                $file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($file_path, $file, $file_name);
                $news->thumbnail = $file_path . $file_name;
            }

            if ($news->save() === false) {
                throw new \Exception('news:failed', ResponseCode::SERVER_ERR);
            }

            DB::commit();

            return $this->responseSuccess(['id' => $news->id], __('成功'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param NewsRequest $request
     * @param News $news
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function update(NewsRequest $request, News $news)
    {
        if (!(($lock = Cache::lock("submit_news_update_lock:$news->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'category_id', 'short', 'start_date', 'end_date', 'description', 'status']);
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');

        try {

            DB::beginTransaction();

            $file = $request->file('thumbnail');
            if ($file) {
                $file_path = FileTool::existsAndMake('news');
                $extension = $file->getClientOriginalExtension();
                $file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($file_path, $file, $file_name);

                $old_path = $news->getRawOriginal('thumbnail');
                FileTool::existsAnddelete($old_path);

                $news->thumbnail = $file_path . $file_name;
            }

            foreach ($inputs as $key => $value) {
                $news->$key = $value;
            }
            $news->start_time = Carbon::createFromFormat('h:i A', $start_time)->format('H:i:s');
            $news->end_time = Carbon::createFromFormat('h:i A', $end_time)->format('H:i:s');

            if ($news->save() === false) {
                throw new \Exception('news:failed', ResponseCode::SERVER_ERR);
            }

            DB::commit();

            return $this->responseSuccess(['id' => $news->id], __('成功'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Request $request
     * @param News $news
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function status(Request $request, News $news)
    {
        if (!(($lock = Cache::lock("submit_news_status_lock:$news->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $status = (int)$request->input('status');

        if ($status === News::STATUS_PUBLISHED) {

            $validator = Validator::make($news->toArray(), [
                'title' => 'bail|required',
                'thumbnail' => 'bail|required',
                'category_id' => 'bail|required|exists:news_categories,id',
                'short' => 'bail|required',
                'start_date' => 'bail|required|date:Y-m-d',
                'end_date' => 'bail|required|date:Y-m-d|after_or_equal:start_date',
                'start_time' => 'bail|required|date:H:i A',
                'end_time' => 'bail|required|date:H:i A|after_or_equal:start_time',
                'description' => 'bail|required'
            ]);

            if ($validator->fails()) {
                throw new ApiException($validator->errors()->first(), ResponseCode::PARAM_ERR);
            }
        }

        try {

            $news->status = $status;
            if ($news->save() === false) {
                throw new \Exception('news:failed', ResponseCode::SERVER_ERR);
            }

            return $this->responseSuccess(0, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param News $news
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function destroy(News $news)
    {
        if (!(($lock = Cache::lock("submit_news_destroy_lock:$news->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        try {

            $old_path = $news->getRawOriginal('thumbnail');
            FileTool::existsAnddelete($old_path);

            $news->delete();

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }
}
