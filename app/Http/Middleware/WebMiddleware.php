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

            $navs[] = [
                'title' => __('「喜步」專業學習社群'),
                'url' => '',
                'icon' => web_resource_url('assets/web/images/resource-kit.svg'),
                'active' => false,
                'has_children' => true,
                'children' => [
                    [
                        'title' => __('海外交流團海報分享'),
                        'url' => route('resource.share.html', ['category' => 18]),
                        'children' => []
                    ],
                    [
                        'title' => __('國際會議匯報海報分享'),
                        'url' => route('resource.share.html', ['category' => 19]),
                        'children' => []
                    ],
                    [
                        'title' => __('幼兒喜步專業學習歷程'),
                        'url' => route('resource.share.html', ['category' => 20]),
                        'children' => []
                    ],
//                    [
//                        'title' => __('幼兒中心專業學習歷程'),
//                        'url' => route('resource.video.html'),
//                        'children' => []
//                    ]
                ]
            ];

            $navs[] = [
                'title' => '知識庫',
                'url' => route('resource.html'),
                'icon' => web_resource_url('assets/web/images/resource-kit-02.svg'),
                'active' => false,
                'has_children' => true,
                'children' => [
                    [
                        'title' => __('文章分享'),
                        'url' => route('resource.html'),
                        'children' => []
                    ],
                    [
                        'title' => __('家長親子學習套'),
                        'url' => route('resource.html', ['category' => 21]),
                        'children' => []
                    ],
                ]
            ];

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
                        'title' => __('按區域顯示'),
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
