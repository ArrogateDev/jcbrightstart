<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function index($page)
    {
        $pages = [
//            'terms-and-conditions.html',
//            'privacy-policy.html',
//            'professional-development.html',
            'contact-us.html'
        ];

        $breadcrumb_maps = [
            'contact-us.html' => '聯絡我們'
        ];

        $breadcrumbs = [
            [
                'title' => $breadcrumb_maps[$page],
                'url' => null,
                'color' => '#4492cf',
            ]
        ];

        $view = in_array($page, $pages) ? 'web.' . str_replace('.html', '', $page) : 'web.under-construction';

        return view($view, compact('breadcrumbs'));
    }

    public function error(Request $request)
    {
        return view('web.404');
    }
}
