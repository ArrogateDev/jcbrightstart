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

class WebMiddleware
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
        $locale = $request->cookie('locale') ?? $request->session()->get('locale');
        $locale = 'zh_HK';
        if ($locale && in_array($locale, ['en', 'zh_CN', 'zh_HK'])) {
            App::setLocale($locale);
            if ($request->cookie('locale') && !$request->session()->has('locale')) {
                session(['locale' => $locale]);
            }
        }

        if (!$request->expectsJson()) {
            $user = $request->user();

            if ($user && Str::contains($request->url(), ['login.html', 'register.html', 'forgot-password.html', 'reset-password.html'])) {
                return to_route('home');
            }

            $navs[] = [
                'title' => __('關於計劃'),
                'url' => route('about-us.html'),
                'icon' => web_resource_url('assets/web/images/about-us.svg'),
                'active' => false,
                'has_children' => false,
                'children' => []
            ];

            $navs[] = [
                'title' => __('最新消息'),
                'url' => route('news.html'),
                'icon' => web_resource_url('assets/web/images/last-news.svg'),
                'active' => false,
                'has_children' => false,
                'children' => []
            ];

            $resources = ResourceCategory::query()
                ->with([
                    'children' => function ($query) {
                        $query->select('id', 'title', 'pid', 'url')->orderBy('sort');
                    }
                ])
                ->where('pid', 0)
                ->orderBy('sort')
                ->select('id', 'title', 'icon', 'url')
                ->get();

            foreach ($resources as $resource) {
                $children = [];
                foreach ($resource->children as $child) {
                    $child_url = !empty($child->url) ? route($child->url, ['n' => $resource->id, 'c' => $child->id]) : route('resource.html', ['n' => $resource->id, 'c' => $child->id]);
                    $children[] = [
                        'title' => __($child->title),
                        'url' => $child_url,
                        'children' => []
                    ];
                }

                $url = !empty($resource->url) ? route($resource->url, ['n' => $resource->id]) : route('resource.html', ['n' => $resource->id]);
                $navs[] = [
                    'title' => __($resource->title),
                    'url' => empty($children) ? $url : '',
                    'icon' => $resource->icon,
                    'active' => false,
                    'has_children' => !empty($children),
                    'children' => $children
                ];
            }

            $navs[] = [
                'title' => __('幼兒服務網絡'),
                'url' => '',
                'icon' => web_resource_url('assets/web/images/maps.svg'),
                'active' => false,
                'has_children' => true,
                'children' => [
                    [
                        'title' => __('按地圖顯示'),
                        'url' => route('maps.html'),
                        'children' => []
                    ],
                    [
                        'title' => __('按服務顯示'),
                        'url' => route('maps-list.html'),
                        'children' => []
                    ],
                    [
                        'title' => __('其他實用連結'),
                        'url' => route('maps-link.html'),
                        'children' => []
                    ]
                ]
            ];

            $navs[] = [
                'title' => __('聯絡我們'),
                'url' => route('page', ['page' => 'contact-us.html']),
                'icon' => web_resource_url('assets/web/images/contact-us.svg'),
                'active' => false,
                'has_children' => false,
                'children' => []
            ];


            $user_menus[] = [
                'title' => __('主菜单'),
                'children' => [
                    [
                        'title' => __('仪表板'),
                        'icon' => '🏠',
                        'url' => route('user.dashboard.html'),
                        'active' => 'dashboard'
                    ],
                    [
                        'title' => __('我的资料'),
                        'icon' => '👤',
                        'url' => route('user.profile.html'),
                        'active' => 'profile'
                    ],
                    [
                        'title' => __('我的课程'),
                        'icon' => '📚',
                        'url' => route('user.course.html'),
                        'active' => 'course'
                    ],
                    [
                        'title' => __('我的证书'),
                        'icon' => '🏅',
                        'url' => route('user.certificate.html'),
                        'active' => 'certificate'
                    ],
                    [
                        'title' => __('我的测验'),
                        'icon' => '📝',
                        'url' => route('user.quiz.html'),
                        'active' => 'quiz'
                    ]
                ]
            ];

            $user_menus[] = [
                'title' => __('账号设置'),
                'children' => [
                    [
                        'title' => __('设置'),
                        'icon' => '⚙️',
                        'url' => route('user.settings.html'),
                        'active' => 'settings'
                    ],
                    [
                        'title' => __('退出登录'),
                        'icon' => '👋',
                        'url' => 'javascript:void(0);',
                        'active' => 'logout',
                        'class' => 'logout'
                    ]
                ]
            ];
            $avatar_menus = array_merge(...array_column($user_menus, 'children'));
            $avatar_menus = array_filter($avatar_menus, fn($item) => $item['active'] !== 'logout');

            View::share('navs', $navs);

            $user = $request->user();

            View::share('user', $user);

            View::share('avatar_menus', $avatar_menus);
            View::share('user_menus', $user_menus);
        }

        $title = __('赛马会幼儿“喜步”计划');

        View::share('title', $title);

        return $next($request);
    }
}
