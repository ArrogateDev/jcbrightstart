<?php

namespace App\Http\Controllers\Admin\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;

class QuizResultController extends Controller
{

    /**
     * @param Quiz $quiz
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Quiz $quiz)
    {
        $total = 0;
        $month_total = 0;
        $week_total = 0;

        return view('admin.quiz.quiz-result', compact('quiz', 'total', 'month_total', 'week_total'));
    }

}
