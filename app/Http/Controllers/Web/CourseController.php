<?php

namespace App\Http\Controllers\Web;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Course\Course;
use App\Models\Course\CourseChapterUnit;
use App\Models\User\UserCoursePlayRecord;
use App\Models\User\UserQuizAnswerRecord;
use App\Models\User\UserUnitQuizStatistics;
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
            'chapters.units'
        ]);
        $course->unit_num = $course->chapters->sum(function ($chapter) {
            return $chapter->units->count();
        });

        $play_records = UserCoursePlayRecord::query()
            ->where('user_id', $user->id ?? 0)
            ->where('course_id', $course->id)
            ->orderByDesc('id')
            ->select('course_id', 'chapter_id', 'unit_id', 'play_position', 'status')
            ->get();

        $course->chapters->map(function ($item) use ($play_records) {
            $item->units->map(function ($unit) use ($play_records) {
                $unit->status = $play_records->where('chapter_id', $unit->chapter_id)->where('unit_id', $unit->id)->value('status') ?? 0;
            });
        });

        $play_record = $play_records->first() ?? null;

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

            $play_record = UserCoursePlayRecord::firstOrCreate(
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

            $play_record = UserCoursePlayRecord::firstOrCreate(
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

        $play_record = UserCoursePlayRecord::query()
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
                'status' => UserCoursePlayRecord::PLAY_COMPLETED,
                'play_position' => $request->play_position ?? $play_record->play_position,
            ]);

            return $this->responseSuccess($play_record);
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Failure', ResponseCode::SERVER_ERR);
        }
    }

    /**
     * 保存答题记录
     *
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleSaveQuizAnswer(Request $request, Course $course)
    {
        $user = $request->user('web');
        if (!(($lock = Cache::lock("submit_handle_save_quiz_answer_lock:$user->id", 30))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $request->validate([
            'chapter_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'quiz_id' => 'required|integer',
            'question_index' => 'required|integer|min:0',
            'user_answer' => 'required|integer|min:0',
            'correct_answer' => 'required|integer|min:0',
        ]);

        if (!CourseChapterUnit::query()
            ->where('course_id', $course->id)
            ->where('chapter_id', $request->chapter_id)
            ->where('id', $request->unit_id)
            ->exists()) {
            throw new ApiException(__('参数错误'), ResponseCode::PARAM_ERR);
        }

        try {
            $is_correct = $request->user_answer === $request->correct_answer;

            // 每次答题都创建新记录，保留历史记录（包括错误答案）
            $answer_record = UserQuizAnswerRecord::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'chapter_id' => $request->chapter_id,
                'unit_id' => $request->unit_id,
                'quiz_id' => $request->quiz_id,
                'question_index' => $request->question_index,
                'user_answer' => $request->user_answer,
                'correct_answer' => $request->correct_answer,
                'is_correct' => $is_correct,
                'answered_at' => now(),
            ]);

            // 更新答题统计（统计时会取最新的答题记录）
            UserUnitQuizStatistics::updateStatistics(
                $user->id,
                $course->id,
                $request->chapter_id,
                $request->unit_id,
                $request->quiz_id,
                $is_correct
            );

            return $this->responseSuccess($answer_record);
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('Failure', ResponseCode::SERVER_ERR);
        }
    }
}
