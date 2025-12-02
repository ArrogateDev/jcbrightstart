<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Course;
use App\Tools\FileTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::query()
            ->groupBy('status')
            ->select(DB::raw('count(id) as count'), 'status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.course.list', ['courses' => $courses]);
    }

    public function view(Course $course)
    {
        return view('admin.course.new', ['course' => $course]);
    }

    /**
     * 证书列表
     */
    public function list(Request $request)
    {
        $keyword = $request->query('keyword');
        $status = $request->query('status');

        $list = Course::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->paginate(limit_page());

        $list->map(function ($item) {
            $item->url = route('admin.course.update.view.html', ['course' => $item->id]);
        });

        return $this->responseSuccess($list);
    }

    /**
     * @param CourseRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function store(CourseRequest $request)
    {
        $user_id = $request->user('admin')->id;
        if (!(($lock = Cache::lock("submit_course_store_lock:$user_id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'video_url', 'category', 'level', 'language', 'short', 'description', 'acquire', 'requirements', 'status']);

        try {

            $file = $request->file('thumbnail');

            $course = new Course();
            foreach ($inputs as $key => $value) {
                $course->$key = $value;
            }

            if ($file) {
                $file_path = FileTool::existsAndMake('course');
                $extension = $file->getClientOriginalExtension();
                $file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($file_path, $file, $file_name);
                $course->thumbnail = $file_path . $file_name;
            }

            if ($course->save() === false) {
                throw new \Exception('course:failed', ResponseCode::SERVER_ERR);
            }

            return $this->responseSuccess(['id' => $course->id], __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param CourseRequest $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function update(CourseRequest $request, Course $course)
    {
        if (!(($lock = Cache::lock("submit_course_update_lock:$course->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'video_url', 'category', 'level', 'language', 'short', 'description', 'acquire', 'requirements', 'status']);

        try {

            $file = $request->file('thumbnail');
            if ($file) {
                $file_path = FileTool::existsAndMake('course');
                $extension = $file->getClientOriginalExtension();
                $file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($file_path, $file, $file_name);

                $old_path = $course->getRawOriginal('thumbnail');
                FileTool::existsAnddelete($old_path);

                $course->thumbnail = $file_path . $file_name;
            }

            foreach ($inputs as $key => $value) {
                $course->$key = $value;
            }
            if ($course->save() === false) {
                throw new \Exception('course:failed', ResponseCode::SERVER_ERR);
            }

            return $this->responseSuccess(['id' => $course->id], __('成功'));
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function destroy(Course $course)
    {
        if (!(($lock = Cache::lock("submit_course_destroy_lock:$course->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        try {

            $old_path = $course->getRawOriginal('thumbnail');
            FileTool::existsAnddelete($old_path);

            $course->delete();

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }
}
