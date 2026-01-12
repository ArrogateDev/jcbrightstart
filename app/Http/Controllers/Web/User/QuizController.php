<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserUnitQuizStatistics;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function index()
    {
        return view('web.user.quiz');
    }

    public function result()
    {
        return view('web.user.quiz-result');
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
