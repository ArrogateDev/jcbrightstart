<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Course\Course;
use App\Models\User\UserCourseCertificate;
use App\Models\User\UserCoursePlayRecord;
use App\Models\User\UserUnitQuizStatistics;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user('web');

        $last_quiz = UserUnitQuizStatistics::query()
            ->with(['course:id,title', 'chapter:id,title', 'unit:id,title', 'quiz:id,title'])
            ->where('user_id', $user->id)
            ->whereColumn('answered', '<', 'total_questions')
            ->orderByDesc('id')
            ->select('id', 'course_id', 'chapter_id', 'unit_id', 'quiz_id', 'total_questions', 'answered')
            ->first() ?? '';
        if ($last_quiz) {
            $last_quiz->url = route('user.quiz-results.html', ['quiz' => $last_quiz->id]);
            $last_quiz->append(['title']);
            $last_quiz->makeHidden(['course_id', 'chapter_id', 'unit_id', 'quiz_id', 'course', 'chapter', 'unit', 'quiz']);
        }

        //我的课程
        $start_course = Course::query()
            ->where('status', Course::STATUS_PUBLISHED)
            ->count();
        //我的证书
        $complete_quizzes = UserCourseCertificate::query()
            ->where('user_id', $user->id)
            ->where('status', UserCourseCertificate::STATUS_GENERATED)
            ->count();
        //待完成课程
        $complete_course = max(0, bcsub($start_course, $complete_quizzes, 0));

        $courses = UserCoursePlayRecord::query()
            ->with([
                'course' => function ($query) {
                    $query->where('status', Course::STATUS_PUBLISHED)->select('id', 'title', 'thumbnail', 'status', 'created_at');
                }
            ])
            ->from(function ($query) {
                $query->select('*')
                    ->selectRaw('ROW_NUMBER() OVER (PARTITION BY course_id ORDER BY id DESC) as row_num')
                    ->from('user_course_play_records')
                    ->whereNull('deleted_at');
            }, 'user_course_play_records')
            ->where('row_num', 1)
            ->orderByDesc('id')
            ->limit(3)
            ->select('id', 'course_id')
            ->get();
        $courses->map(function ($course) {
            $course->url = route('course.details.html', ['course' => $course->course_id]);
        });
        $courses->filter(function ($course) {
            return $course->course;
        });

        $quizzes = UserUnitQuizStatistics::query()
            ->with(['course:id,title', 'chapter:id,title', 'unit:id,title', 'quiz:id,title'])
            ->where('user_id', $user->id)
            ->limit(5)
            ->orderByDesc('id')
            ->select('id', 'course_id', 'chapter_id', 'unit_id', 'quiz_id', 'total_questions', 'answered')
            ->get();

        $quizzes->append(['title']);
        $quizzes->makeHidden(['course_id', 'chapter_id', 'unit_id', 'quiz_id', 'course', 'chapter', 'unit', 'quiz']);
        $quizzes->map(function ($quiz) {
            $quiz->finishing_rate = $quiz->answered > 0 ? bcdiv($quiz->answered, $quiz->total_questions, 2) * 100 : 0;
        });

        $result = compact('last_quiz', 'start_course', 'complete_course', 'complete_quizzes', 'courses', 'quizzes');

        return view('web.user.dashboard', $result);
    }

}
