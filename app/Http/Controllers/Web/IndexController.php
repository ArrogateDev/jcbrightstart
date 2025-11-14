<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function index()
    {
        return view('web.index');
    }

    public function other(int $no = 2)
    {
        $no = $no > 6 ? 2 : $no;
        $no = $no < 2 ? 2 : $no;

        return view('web.index-' . $no);
    }

}
