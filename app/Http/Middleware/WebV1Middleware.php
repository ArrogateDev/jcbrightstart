<?php

namespace App\Http\Middleware;

use App\Models\Resource\ResourceCategory;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class WebV1Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $title = '賽馬會幼兒「喜步」計劃';

        $navs[] = [
            'title' => __('關於計劃'),
            'url' => '',
            'icon' => web_resource_url('assets/web/images/v1/about-us.svg'),
            'active' => false,
            'children' => []
        ];

        $navs[] = [
            'title' => __('计划消息'),
            'url' => '',
            'icon' => web_resource_url('assets/web/images/v1/last-news.svg'),
            'active' => false,
            'children' => []
        ];

        $navs[] = [
            'title' => __('幼兒服務資訊'),
            'url' => '',
            'icon' => web_resource_url('assets/web/images/v1/maps.svg'),
            'active' => false,
            'children' => [
                [
                    'title' => __('地图'),
                    'url' => route('maps.html'),
                    'children' => []
                ],
                [
                    'title' => __('列表'),
                    'url' => route('maps-list.html'),
                    'children' => []
                ]
            ]
        ];

        $resource_category = ResourceCategory::query()
            ->where('pid', 0)
            ->select('id', 'title')
            ->get();

        $resource_children = [];
        foreach ($resource_category as $item) {
            $resource_children[] = [
                'title' => $item->title,
                'url' => route('resource.more.html', ['type' => 0, 'mod' => $item->id]),
                'children' => []
            ];
        }
        $resource_children[] = [
            'title' => __('影片分享'),
            'url' => route('resource.more.html', ['type' => 1]),
            'children' => []
        ];

        $navs[] = [
            'title' => __('專業學習社群'),
            'url' => '',
            'icon' => web_resource_url('assets/web/images/v1/resource-kit.svg'),
            'active' => false,
            'children' => $resource_children
        ];

        $navs[] = [
            'title' => __('聯絡我們'),
            'url' => '',
            'icon' => web_resource_url('assets/web/images/v1/contact-us.svg'),
            'active' => false,
            'children' => []
        ];

        View::share('title', $title);
        View::share('navs', $navs);

        return $next($request);
    }
}
