<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;

class CertificateController extends Controller
{

    public function index()
    {
        return view('web.user.certificate');
    }

}
