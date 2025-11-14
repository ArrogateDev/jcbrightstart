<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class PageController extends Controller
{

    public function index($page)
    {
        $pages = [
            'terms-and-conditions.html',
            'privacy-policy.html',
            'about-us.html',
            'faq.html',
            'contact-us.html'
        ];

        $view = in_array($page, $pages) ? 'web.' . str_replace('.html', '', $page) : 'web.index';
        return view($view);
    }
}
