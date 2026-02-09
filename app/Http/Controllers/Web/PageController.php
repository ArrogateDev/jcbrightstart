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
            'about-us.html',
            'professional-development.html',
            'contact-us.html'
        ];

        $view = in_array($page, $pages) ? 'web.' . str_replace('.html', '', $page) : 'web.index';
        return view($view);
    }

    public function error(Request $request)
    {
        return view('web.404');
    }
}
