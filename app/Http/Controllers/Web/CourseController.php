<?php

namespace App\Http\Controllers\Web;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseChapterUnit;
use App\Models\CoursePlayRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{

    public function index()
    {
    }

    /**
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request, Course $course)
    {
        $user = $request->user('web');
        $course->load([
            'chapters:id,course_id,title',
            'chapters.units',
            'chapters.units.quiz:id,title'
        ]);

        $play_record = null;
        if ($user) {
            $play_record = CoursePlayRecord::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->orderByDesc('id')
                ->first();
        }

        return view('web.course.show', compact('course', 'play_record'));
    }

    /**
     * 保存播放记录
     *
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleSavePlayRecord(Request $request, Course $course)
    {
        $user = $request->user('web');
        if (!(($lock = Cache::lock("submit_handle_save_play_record_lock:$user->id", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $request->validate([
            'chapter_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'play_position' => 'nullable|integer|min:0',
        ]);

        if (CourseChapterUnit::query()->where('course_id', $course->id)->where('course_id', $course->id)->where('chapter_id', $course->id)) {
            throw new ApiException(__('参数错误'), ResponseCode::PARAM_ERR);
        }

        try {

            $play_record = CoursePlayRecord::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'chapter_id' => $request->chapter_id,
                    'unit_id' => $request->unit_id,
                ],
                [
                    'play_position' => $request->play_position
                ]
            );

            return $this->responseSuccess($play_record);
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Failure', ResponseCode::SERVER_ERR);
        }
    }

    /**
     * 记录播放开始
     *
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleRecordPlayStart(Request $request, Course $course)
    {
        $user = $request->user('web');
        if (!(($lock = Cache::lock("submit_handle_record_play_start_lock:$user->id", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $request->validate([
            'chapter_id' => 'required|integer',
            'unit_id' => 'required|integer',
        ]);

        if (!CourseChapterUnit::query()->where('course_id', $course->id)->where('chapter_id', $request->chapter_id)->where('id', $request->unit_id)->exists()) {
            throw new ApiException(__('参数错误'), ResponseCode::PARAM_ERR);
        }

        try {

            $play_record = CoursePlayRecord::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'chapter_id' => $request->chapter_id,
                    'unit_id' => $request->unit_id,
                ],
                [
                    'start_time' => now(),
                    'play_position' => 0,
                ]
            );

            return $this->responseSuccess($play_record);
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Failure', ResponseCode::SERVER_ERR);
        }
    }

    /**
     * 记录播放结束
     *
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleRecordPlayEnd(Request $request, Course $course)
    {
        $user = $request->user('web');
        if (!(($lock = Cache::lock("submit_handle_record_play_end_lock:$user->id", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $request->validate([
            'chapter_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'play_position' => 'nullable|integer|min:0'
        ]);

        if (!CourseChapterUnit::query()->where('course_id', $course->id)->where('chapter_id', $request->chapter_id)->where('id', $request->unit_id)->exists()) {
            throw new ApiException(__('参数错误'), ResponseCode::PARAM_ERR);
        }

        $play_record = CoursePlayRecord::query()
            ->where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('chapter_id', $request->chapter_id)
            ->where('unit_id', $request->unit_id)
            ->firstOr(function () {
                throw new ApiException(__('播放记录不存在'), ResponseCode::NOT_FOUND);
            });

        try {

            $endTime = now();
            $duration = 0;

            if ($play_record->start_time) {
                $duration = $endTime->diffInSeconds($play_record->start_time);
            }

            $play_record->update([
                'end_time' => $endTime,
                'duration' => $duration,
                'play_position' => $request->play_position ?? $play_record->play_position,
            ]);

            return $this->responseSuccess($play_record);
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Failure', ResponseCode::SERVER_ERR);
        }
    }
}
