<?php

namespace App\Http\Middleware;

use App\Models\NewsCategory;
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
        $locale = session('locale', config('app.locale', 'zh_HK'));
        App::setLocale($locale);

        if (!$request->expectsJson()) {
            $user = $request->user();

            if ($user && Str::contains($request->url(), ['login.html', 'register.html', 'forgot-password.html', 'reset-password.html'])) {
                return to_route('home');
            }

            $navs[] = [
                'title' => __('關於我們'),
                'url' => route('page', ['page' => 'about-us.html']),
                'children' => [
                    [
                        'title' => __('參與幼兒中心名稱'),
                        'url' => route('page', ['page' => 'about-us.html']),
                        'children' => [
                            [
                                'title' => 'Cohort 1',
                                'url' => route('page', ['page' => 'about-us.html']),
                            ],
                            [
                                'title' => 'Cohort 2',
                                'url' => route('page', ['page' => 'about-us.html']),
                            ],
                            [
                                'title' => 'Cohort 3',
                                'url' => route('page', ['page' => 'about-us.html']),
                            ]
                        ]
                    ],
                    [
                        'title' => __('計劃團隊'),
                        'url' => route('page', ['page' => 'about-us.html']),
                        'children' => [
                            [
                                'title' => __('計劃總監暨首席研究員'),
                                'url' => route('page', ['page' => 'about-us.html']),
                            ],
                            [
                                'title' => __('首席聯席研究員'),
                                'url' => route('page', ['page' => 'about-us.html']),
                            ],
                            [
                                'title' => __('聯席研究員'),
                                'url' => route('page', ['page' => 'about-us.html']),
                            ]
                        ]
                    ],
                    [
                        'title' => __('計劃夥伴'),
                        'url' => route('page', ['page' => 'about-us.html']),
                        'children' => [
                            [
                                'title' => __('主編機構'),
                                'url' => route('page', ['page' => 'about-us.html']),
                            ],
                            [
                                'title' => __('捐助機構'),
                                'url' => route('page', ['page' => 'about-us.html']),
                            ],
                            [
                                'title' => __('專業合作夥伴'),
                                'url' => route('page', ['page' => 'about-us.html']),
                            ]
                        ]
                    ]
                ]
            ];

            $new_category = NewsCategory::query()
                ->where('is_nav', 0)
                ->where('status', 0)
                ->select('id', 'title')
                ->get();
            $new_children = [];
            foreach ($new_category as $new) {
                $new_children[] = [
                    'title' => $new->title,
                    'url' => route('news.html'),
                ];
            }
            if (!empty($new_category)) {
                array_unshift($new_children, [
                    'title' => __('全部'),
                    'url' => route('news.html')
                ]);
            }
            $navs[] = [
                'title' => __('最新消息'),
                'url' => route('news.html'),
                'children' => $new_children
            ];

            $navs[] = [
                'title' => __('香港0-3歲嬰幼兒服務資訊'),
                'url' => route('maps.html'),
                'children' => []
            ];

            $navs[] = [
                'title' => __('教師專業發展'),
                'url' => route('page', ['page' => 'about-us.html']),
                'children' => []
            ];

            $navs[] = [
                'title' => __('聯繫我們'),
                'url' => route('page', ['page' => 'contact-us.html']),
                'children' => []
            ];

            View::share('user', $user);
            View::share('navs', $navs);
        }

        return $next($request);
    }
}
