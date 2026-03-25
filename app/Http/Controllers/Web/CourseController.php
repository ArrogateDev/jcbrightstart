<?php

namespace App\Http\Controllers\Web;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Jobs\CreateCourseCertificateJob;
use App\Models\Certificate;
use App\Models\Course\Course;
use App\Models\Course\CourseChapterUnit;
use App\Models\Quiz;
use App\Models\User\UserCourseCertificate;
use App\Models\User\UserCoursePlayRecord;
use App\Models\User\UserQuizAnswerRecord;
use App\Models\User\UserUnitQuizStatistics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

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

        $course->chapter_num = $course->chapters->count();
        $course->unit_num = $course->chapters->sum(function ($chapter) {
            return $chapter->units->count();
        });

        $certificate = UserCourseCertificate::query()
            ->where('user_id', $user->id ?? 0)
            ->where('course_id', $course->id)
            ->first();

        $course->certificate_url = $certificate->file_url ?? null;
        $course->certificate_download_url = $course->certificate_url ? env('APP_URL') . URL::temporarySignedRoute(
                'user.download.html', now()->addDay(), ['file' => $certificate->file], false
            ) : null;

        $play_records = UserCoursePlayRecord::query()
            ->where('user_id', $user->id ?? 0)
            ->where('course_id', $course->id)
            ->orderByDesc('id')
            ->select('course_id', 'chapter_id', 'unit_id', 'status')
            ->get();

        $course->chapters->map(function ($item) use ($play_records) {
            $item->unit_num = $item->units->count();
            $item->units->map(function ($unit) use ($play_records) {
                $unit->url = route('course.unit.details.html', ['course' => $unit->course_id, 'unit' => $unit->id]);
                $unit->status = $play_records->where('chapter_id', $unit->chapter_id)->where('unit_id', $unit->id)->value('status') ?? 0;
            });
            $item->unit_num_completed = $item->units->where('status', UserCoursePlayRecord::QUIZ_COMPLETED)->count();
        });

        $read_completed = UserCoursePlayRecord::query()
            ->where('user_id', $user->id ?? 0)
            ->where('course_id', $course->id)
            ->where('status', '>', UserCoursePlayRecord::UNFINISHED)
            ->count() ?? 0;

        $completed = UserCoursePlayRecord::query()
            ->where('user_id', $user->id ?? 0)
            ->where('course_id', $course->id)
            ->where('status', UserCoursePlayRecord::QUIZ_COMPLETED)
            ->count() ?? 0;

        $progress = $completed > 0 ? bcdiv($completed, $course->unit_num, 2) * 100 : 0;
        $surplus = $course->unit_num - $completed;
        $surplus = $surplus < 0 ? 0 : $surplus;

        $play_record = $play_records->where('status', UserCoursePlayRecord::UNFINISHED)->first() ?? null;

        return view('web.course.new.show', compact('course', 'read_completed', 'completed', 'progress', 'surplus', 'play_record'));
//        return view('web.course.show', compact('course', 'play_record'));
    }

    public function handleUnitShow(Request $request, Course $course, CourseChapterUnit $unit)
    {
        $user = $request->user('web');

        $play_record = UserCoursePlayRecord::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('chapter_id', $unit->chapter_id)
            ->where('unit_id', $unit->id)
            ->first() ?? null;

        $answer_records = UserQuizAnswerRecord::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('chapter_id', $unit->chapter_id)
            ->where('unit_id', $unit->unit_id)
            ->where('quiz_id', $unit->quiz_id)
            ->get();

        // 按题目索引分组，取最新的答题记录
        // 返回所有已答过的题目索引（不管对错），用于判断哪些题目已经答过
        $answered_questions = $answer_records
            ->groupBy('question_index')
            ->keys()
            ->map(function ($index) {
                return (int)$index;
            })
            ->toArray();

        // 同时返回已答对的题目索引，用于统计
        $completed_questions = $answer_records
            ->groupBy('question_index')
            ->map(function ($records) {
                return $records->sortByDesc('answered_at')->first();
            })
            ->filter(function ($record) {
                return $record->is_correct === true;
            })
            ->keys()
            ->map(function ($index) {
                return (int)$index;
            })
            ->toArray();

        $quiz = Quiz::query()
            ->where('id', $unit->quiz_id)
            ->select('title', 'question_num', 'questions')
            ->first();

        $prev = CourseChapterUnit::query()
            ->where('course_id', $course->id)
            ->where('id', '<', $unit->id)
            ->orderBy('id')
            ->value('id');

        $next = CourseChapterUnit::query()
            ->where('course_id', $course->id)
            ->where('id', '>', $unit->id)
            ->orderBy('id')
            ->value('id');

        return view('web.course.new.show-unit', compact('course', 'unit', 'play_record', 'quiz', 'answered_questions', 'completed_questions', 'prev', 'next'));
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
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
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

        if (!CourseChapterUnit::query()->where('course_id', $course->id)->where('chapter_id', $request->chapter_id)->where('id', $request->unit_id)->exists()) {
            throw new ApiException(__('参数错误'), ResponseCode::PARAM_ERR);
        }

        try {

            $result = UserCoursePlayRecord::query()
                ->firstOrCreate(
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
            if ($result === false) {
                throw new \Exception('log:failed');
            }

            return $this->responseSuccess();
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
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
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
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

            $play_record = UserCoursePlayRecord::query()
                ->firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                        'chapter_id' => $request->chapter_id,
                        'unit_id' => $request->unit_id,
                    ],
                    [
                        'play_position' => 0,
                    ]
                );

            $play_record->start_time = now();
            if ($play_record === false) {
                throw new \Exception('log:failed');
            }

            return $this->responseSuccess();
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
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
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
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
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('chapter_id', $request->chapter_id)
            ->where('unit_id', $request->unit_id)
            ->firstOr(function () {
                throw new ApiException(__('播放记录不存在'), ResponseCode::NOT_FOUND);
            });

        try {

            $end_time = now();
            $duration = 0;

            if ($play_record->start_time) {
                $duration = $end_time->diffInSeconds($play_record->start_time);
            }

            $result = $play_record->update([
                'end_time' => $end_time,
                'duration' => $duration,
                'status' => UserCoursePlayRecord::PLAY_COMPLETED,
                'play_position' => $request->play_position ?? $play_record->play_position,
            ]);
            if ($result === false) {
                throw new \Exception('log:failed');
            }

            $quiz = CourseChapterUnit::query()
                ->where('course_id', $course->id)
                ->where('chapter_id', $request->chapter_id)
                ->where('id', $request->unit_id)
                ->value('quiz_id');

            return $this->responseSuccess(['quiz' => $quiz]);
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
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
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
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
        ]);

        $play_record = UserCoursePlayRecord::query()
            ->firstOrCreate(
                [
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'chapter_id' => $request->chapter_id,
                    'unit_id' => $request->unit_id,
                ],
                [
                    'play_position' => 0,
                ]
            );

        if (!CourseChapterUnit::query()
            ->where('course_id', $course->id)
            ->where('chapter_id', $request->chapter_id)
            ->where('id', $request->unit_id)
            ->exists()) {
            throw new ApiException(__('参数错误'), ResponseCode::PARAM_ERR);
        }

        try {

            $quiz = Quiz::find($request->quiz_id);
            if (!$quiz || !is_array($quiz->questions) || empty($quiz->questions)) {
                throw new ApiException(__('测验数据不存在'), ResponseCode::NOT_FOUND);
            }

            $question_index = $request->question_index;

            $question = $quiz->questions[$question_index];
            $correct_answer = (int)($question['correct_answer'] ?? 0);
            $user_answer = (int)$request->user_answer;

            $is_correct = $user_answer === $correct_answer;

            DB::beginTransaction();

            $record = new UserQuizAnswerRecord();
            $record->user_id = $user->id;
            $record->course_id = $course->id;
            $record->chapter_id = $request->chapter_id;
            $record->unit_id = $request->unit_id;
            $record->quiz_id = $request->quiz_id;
            $record->question_index = $question_index;
            $record->user_answer = $user_answer;
            $record->correct_answer = $correct_answer;
            $record->is_correct = $is_correct;
            $record->answered_at = now();
            if ($record->save() === false) {
                throw new \Exception('log:failed');
            }

            $statistics = UserUnitQuizStatistics::updateStatistics(
                $user->id,
                $course->id,
                $request->chapter_id,
                $request->unit_id,
                $request->quiz_id,
                $is_correct
            );

            if ($statistics->total_questions > 0 && $statistics->answered >= $statistics->total_questions) {
                $play_record->update([
                    'status' => UserCoursePlayRecord::QUIZ_COMPLETED,
                ]);
            }

            $completed = UserCoursePlayRecord::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('status', UserCoursePlayRecord::QUIZ_COMPLETED)
                ->select(DB::raw('COUNT(DISTINCT unit_id) as num'))
                ->value('num');

            $course->load([
                'chapters.units'
            ]);
            $course->unit_num = $course->chapters->sum(function ($chapter) {
                return $chapter->units->count();
            });
            $is_completed = $completed >= $course->unit_num;
            if ($is_completed) {
                $certificate = new UserCourseCertificate();
                $certificate->user_id = $user->id;
                $certificate->course_id = $course->id;
                $certificate->certificate_id = 0;
                $certificate->certificate_name = '';
                if ($certificate->save() === false) {
                    throw new \Exception('certificate:failed');
                }

            }

            DB::commit();

            return $this->responseSuccess(['completed' => $is_completed]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * 获取用户已完成的题目索引
     *
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function getAnsweredQuestions(Request $request, Course $course)
    {
        $user = $request->user('web');

        $request->validate([
            'chapter_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'quiz_id' => 'required|integer',
        ]);

        try {
            // 获取该用户在该单元的所有答题记录
            $answer_records = UserQuizAnswerRecord::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('chapter_id', $request->chapter_id)
                ->where('unit_id', $request->unit_id)
                ->where('quiz_id', $request->quiz_id)
                ->get();

            // 按题目索引分组，取最新的答题记录
            // 返回所有已答过的题目索引（不管对错），用于判断哪些题目已经答过
            $answered_questions = $answer_records
                ->groupBy('question_index')
                ->keys()
                ->map(function ($index) {
                    return (int)$index;
                })
                ->toArray();

            // 同时返回已答对的题目索引，用于统计
            $completed_questions = $answer_records
                ->groupBy('question_index')
                ->map(function ($records) {
                    return $records->sortByDesc('answered_at')->first();
                })
                ->filter(function ($record) {
                    return $record->is_correct === true;
                })
                ->keys()
                ->map(function ($index) {
                    return (int)$index;
                })
                ->toArray();

            return $this->responseSuccess([
                'answered_questions' => $answered_questions,  // 所有已答过的题目（不管对错）
                'completed_questions' => $completed_questions  // 已答对的题目
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * 获取测验统计信息
     *
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function getQuizStatistics(Request $request, Course $course)
    {
        $user = $request->user('web');

        $request->validate([
            'chapter_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'quiz_id' => 'required|integer',
        ]);

        try {
            // 获取统计记录
            $statistics = UserUnitQuizStatistics::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('chapter_id', $request->chapter_id)
                ->where('unit_id', $request->unit_id)
                ->where('quiz_id', $request->quiz_id)
                ->first();

            if (!$statistics) {
                throw new ApiException(__('统计信息不存在'), ResponseCode::NOT_FOUND);
            }

            // 检查是否完成所有测验
            $completed = UserCoursePlayRecord::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('status', UserCoursePlayRecord::QUIZ_COMPLETED)
                ->select(DB::raw('COUNT(DISTINCT unit_id) as num'))
                ->value('num');

            $course->load([
                'chapters.units'
            ]);
            $course->unit_num = $course->chapters->sum(function ($chapter) {
                return $chapter->units->count();
            });
            $is_all_completed = $completed >= $course->unit_num;

            // 检查证书状态（是否有签名）
            $certificate = UserCourseCertificate::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();

            $has_signature = $certificate && !empty($certificate->full_name);
            $certificate_file = $certificate ? $certificate->file : null;

            return $this->responseSuccess([
                'total_questions' => $statistics->total_questions,
                'answered' => $statistics->answered,
                'correct_rate' => 100,
                'is_all_completed' => $is_all_completed,
                'has_signature' => $has_signature,
                'certificate_file' => $certificate_file,
            ]);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function handleCertificate(Request $request, Course $course)
    {
        $user = $request->user('web');
        if (!(($lock = Cache::lock("submit_handle_certificate_lock:$user->id", 30))->get())) {
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $name = $request->name ?? $user->full_name;

        try {

            DB::beginTransaction();

            $certificate = Certificate::query()->find($course->certificate_id);

            $user_certificate = UserCourseCertificate::query()
                ->firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'certificate_id' => $certificate->id,
                        'certificate_name' => $certificate->name,
                        'full_name' => $name,
                    ]);
            $user_certificate->certificate_id = $certificate->id;
            $user_certificate->certificate_name = $certificate->name;
            $user_certificate->full_name = $name;
            if ($user_certificate->save() === false) {
                throw new \Exception(__('failed'), ResponseCode::SERVER_ERR);
            }

            CreateCourseCertificateJob::dispatch($user_certificate)->afterCommit();

            DB::commit();

            return $this->responseSuccess();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * 检查证书生成状态
     *
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function checkCertificateStatus(Request $request, Course $course)
    {
        $user = $request->user('web');

        try {
            $certificate = UserCourseCertificate::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();

            if (!$certificate) {
                return $this->responseSuccess([
                    'status' => UserCourseCertificate::STATUS_NOT_GENERATED,
                    'file' => null,
                    'download_url' => null,
                ]);
            }

            $data = [
                'status' => $certificate->status,
            ];

            // 如果证书已生成，返回下载链接
            if ($certificate->status === UserCourseCertificate::STATUS_GENERATED && $certificate->file) {
                $data['file'] = $certificate->file_url;
                $data['download_url'] = env('APP_URL') . URL::temporarySignedRoute(
                        'user.download.html', now()->addDay(), ['file' => $certificate->file], false
                    );
            } else {
                $data['download_url'] = null;
            }

            return $this->responseSuccess($data);
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }
}
