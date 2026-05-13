<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function index($page)
    {
        $pages = [
            'test.html',
            'terms-and-conditions.html',
            'privacy-policy.html',
//            'professional-development.html',
            'contact-us.html',
            'test001.html',
        ];

        $view = in_array($page, $pages) ? 'web.' . str_replace('.html', '', $page) : 'web.index';

        return view($view);
    }

    public function v1Index($page)
    {
        $pages = [
            'about-us.html',
        ];

        $view = in_array($page, $pages) ? 'web.v1.' . str_replace('.html', '', $page) : 'web.v1.index';

        return view($view);
    }

    public function error(Request $request)
    {
        return view('web.404');
    }
}
