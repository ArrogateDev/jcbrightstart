<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{

    public function index()
    {
        return view('web.user.settings');
    }

}
