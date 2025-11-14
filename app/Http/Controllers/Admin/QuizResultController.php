<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class QuizResultController extends Controller
{

    public function index()
    {
        return view('admin.quiz-result');
    }

}
