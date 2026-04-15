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

            $url = $request->url();

            $navs[] = [
                'title' => __('首页'),
                'url' => route('index.html'),
                'active' => $url === route('index.html'),
                'children' => []
            ];

            $navs[] = [
                'title' => __('HOME2_TITLE'),
                'url' => route('index.html') . '#plan',
                'active' => $url === route('index.html') . '#plan',
                'children' => []
            ];

            $navs[] = [
                'title' => __('最新消息'),
                'url' => route('news.html'),
                'active' => str_contains($url, '/latest-news'),
                'children' => []
            ];

            $navs[] = [
                'title' => __('香港0-3岁婴幼儿服务资讯'),
                'url' => route('maps.html'),
                'active' => str_contains($url, '/maps'),
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
                'title' => __('专业学习社群'),
                'url' => route('resource.html'),
                'active' => str_contains($url, '/resource-kit'),
                'children' => $resource_children
            ];

            $navs[] = [
                'title' => __('联系我们'),
                'active' => $url === route('page', ['page' => 'contact-us.html']),
                'url' => route('page', ['page' => 'contact-us.html']),
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

            View::share('user', $user);
            View::share('navs', $navs);

            View::share('avatar_menus', $avatar_menus);
            View::share('user_menus', $user_menus);
        }

        $title = __('赛马会幼儿“喜步”计划');

        View::share('title', $title);

        return $next($request);
    }
}
