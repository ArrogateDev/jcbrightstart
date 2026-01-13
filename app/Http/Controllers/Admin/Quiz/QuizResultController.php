<?php

namespace App\Http\Controllers\Admin\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\User\UserUnitQuizStatistics;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizResultController extends Controller
{

    /**
     * @param Quiz $quiz
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Quiz $quiz)
    {
        $now = Carbon::now();
        $base_query = UserUnitQuizStatistics::query()
            ->where('quiz_id', $quiz->id)
            ->whereColumn('answered', '>=', 'total_questions');

        $total = (clone $base_query)->count(DB::raw('DISTINCT user_id'));

        $month_total = (clone $base_query)
            ->whereBetween('completed_at', [$now->copy()->subMonth()->startOfDay(), $now])
            ->count(DB::raw('DISTINCT user_id'));

        $week_total = (clone $base_query)
            ->whereBetween('completed_at', [$now->copy()->subWeek()->startOfDay(), $now])
            ->count(DB::raw('DISTINCT user_id'));

        return view('admin.quiz.quiz-result', compact('quiz', 'total', 'month_total', 'week_total'));
    }

    /**
     * @param Request $request
     * @param Quiz $quiz
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, Quiz $quiz)
    {
        $field = $request->query('field', 'completed_at');
        $sort = $request->query('sort');

        $list = UserUnitQuizStatistics::query()
            ->with(['user:id,full_name,avatar'])
            ->where('quiz_id', $quiz->id)
            ->when($field, function ($query) use ($field, $sort) {
                $query->orderBy($field, $sort);
            }, function ($query) {
                $query->orderByDesc('id');
            })
            ->select('id', 'user_id', 'answered', 'completed_at')
            ->paginate(limit_page());

        return $this->responseSuccess($list);
    }
}
