<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;

class QuizController extends Controller
{

    public function index()
    {
        return view('web.user.quiz');
    }

}
