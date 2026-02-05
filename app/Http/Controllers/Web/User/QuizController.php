<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\User\UserQuizAnswerRecord;
use App\Models\User\UserUnitQuizStatistics;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function index()
    {
        return view('web.user.quiz');
    }

    public function result(Request $request, UserUnitQuizStatistics $quiz)
    {
        $user = $request->user('web');
        if ($quiz->user_id !== $user->id) {
            abort(403);
        }

        // 判断是否完成：answered >= total_questions 且 total_questions > 0
        $is_completed = $quiz->total_questions > 0 && $quiz->answered >= $quiz->total_questions;

        $quiz_data = null;
        $user_answers = [];

        // 如果已完成，获取测验题目和用户答案
        if ($is_completed) {
            // 获取测验数据
            $quizModel = Quiz::find($quiz->quiz_id);
            if ($quizModel && is_array($quizModel->questions)) {
                $quiz_data = $quizModel->questions;
            }

            // 获取用户答题记录，按题目索引分组，取最新的答案
            $answer_records = UserQuizAnswerRecord::query()
                ->where('user_id', $user->id)
                ->where('course_id', $quiz->course_id)
                ->where('chapter_id', $quiz->chapter_id)
                ->where('unit_id', $quiz->unit_id)
                ->where('quiz_id', $quiz->quiz_id)
                ->orderBy('answered_at', 'desc')
                ->get()
                ->groupBy('question_index')
                ->map(function ($records) {
                    return $records->first(); // 取最新的答案
                });

            // 转换为数组，key为题目索引
            foreach ($answer_records as $index => $record) {
                $user_answers[(int)$index] = [
                    'user_answer' => $record->correct_answer,
                    'correct_answer' => $record->correct_answer,
                    'is_correct' => 1,
//                    'is_correct' => $record->is_correct,
                ];
            }
        }

        $quiz->correct_rate = 100;
        $quiz->correct = $quiz->total_questions;

        return view('web.user.quiz-result', [
            'quiz_statistics' => $quiz,
            'is_completed' => $is_completed,
            'course_id' => $quiz->course_id,
            'quiz_data' => $quiz_data,
            'user_answers' => $user_answers,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $user = $request->user('web');

        $list = UserUnitQuizStatistics::query()
            ->with(['course:id,title', 'chapter:id,title', 'unit:id,title', 'quiz:id,title'])
            ->where('user_id', $user->id)
            ->select('id', 'course_id', 'chapter_id', 'unit_id', 'quiz_id', 'total_questions')
            ->paginate(limit_page());

        $list->append(['title']);
        $list->makeHidden(['course_id', 'chapter_id', 'unit_id', 'quiz_id', 'course', 'chapter', 'unit', 'quiz']);
        $list->map(function ($item) {
            $item->url = route('user.quiz-results.html', ['quiz' => $item->id]);
        });

        return $this->responseSuccess($list);
    }
}
