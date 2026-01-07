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

//            $navs[] = [
//                'title' => __('關於我們'),
//                'url' => route('page', ['page' => 'about-us.html']),
//                'children' => [
//                    [
//                        'title' => __('參與幼兒中心名稱'),
//                        'url' => route('page', ['page' => 'about-us.html']),
//                        'children' => [
//                            [
//                                'title' => 'Cohort 1',
//                                'url' => route('page', ['page' => 'about-us.html']),
//                            ],
//                            [
//                                'title' => 'Cohort 2',
//                                'url' => route('page', ['page' => 'about-us.html']),
//                            ],
//                            [
//                                'title' => 'Cohort 3',
//                                'url' => route('page', ['page' => 'about-us.html']),
//                            ]
//                        ]
//                    ],
//                    [
//                        'title' => __('計劃團隊'),
//                        'url' => route('page', ['page' => 'about-us.html']),
//                        'children' => [
//                            [
//                                'title' => __('計劃總監暨首席研究員'),
//                                'url' => route('page', ['page' => 'about-us.html']),
//                            ],
//                            [
//                                'title' => __('首席聯席研究員'),
//                                'url' => route('page', ['page' => 'about-us.html']),
//                            ],
//                            [
//                                'title' => __('聯席研究員'),
//                                'url' => route('page', ['page' => 'about-us.html']),
//                            ]
//                        ]
//                    ],
//                    [
//                        'title' => __('計劃夥伴'),
//                        'url' => route('page', ['page' => 'about-us.html']),
//                        'children' => [
//                            [
//                                'title' => __('主編機構'),
//                                'url' => route('page', ['page' => 'about-us.html']),
//                            ],
//                            [
//                                'title' => __('捐助機構'),
//                                'url' => route('page', ['page' => 'about-us.html']),
//                            ],
//                            [
//                                'title' => __('專業合作夥伴'),
//                                'url' => route('page', ['page' => 'about-us.html']),
//                            ]
//                        ]
//                    ]
//                ]
//            ];

            $navs[] = [
                'title' => __('最新消息'),
                'url' => route('news.html'),
                'children' => []
            ];

            $navs[] = [
                'title' => __('香港0-3歲嬰幼兒服務資訊'),
                'url' => route('maps.html'),
                'children' => [
                    [
                        'title' => __('服務機構地址'),
                        'url' => '',
                        'children' => []
                    ],
                    [
                        'title' => __('0-3歲相關實用連結'),
                        'url' => route('maps.html'),
                        'children' => [
                            [
                                'title' => __('社會福利署幼兒中心'),
                                'url' => 'https://www.swd.gov.hk/tc/pubsvc/family/cat_childcareservice/daychildcares/cccs/index.html',
                                'children' => [],
                                'target'=>'_blank'
                            ],
                            [
                                'title' => __('受資助及私營／非牟利的獨立幼兒中心名單及電話'),
                                'url' => 'https://www.swd.gov.hk/storage/asset/section/644/tc/Child_Care_Centre_cccai_as_at_2025-07-25.pdf',
                                'children' => [],
                                'target'=>'_blank'
                            ],
                            [
                                'title' => __('鄰里支援幼兒照顧計劃'),
                                'url' => 'https://www.swd.gov.hk/tc/pubsvc/family/cat_childcareservice/daychildcares/nsccp/index.html',
                                'children' => [],
                                'target'=>'_blank'
                            ],
                            [
                                'title' => __('「日間幼兒照顧服務」服務單張'),
                                'url' => 'https://www.swd.gov.hk/storage/asset/section/264/tc/Day%20Child%20Care%20Services%20Leaflet_TradChi%26Eng_Sept%2024.pdf',
                                'children' => [],
                                'target'=>'_blank'
                            ],
                            [
                                'title' => __('母嬰健康院'),
                                'url' => 'https://www.fhs.gov.hk/tc_chi/centre_det/maternal/maternal.html',
                                'children' => [],
                                'target'=>'_blank'
                            ],
                            [
                                'title' => __('接種疫苗'),
                                'url' => 'https://www.fhs.gov.hk/tc_chi/health_info/child/14828.html',
                                'children' => [],
                                'target'=>'_blank'
                            ],
                            [
                                'title' => __('新生嬰兒獎勵金'),
                                'url' => 'https://www.cso.gov.hk/newbornbabybonus/chi/index.htm',
                                'children' => [],
                                'target'=>'_blank'
                            ],
                            [
                                'title' => __('兒童健康攻略'),
                                'url' => 'https://www.healthbureau.gov.hk/phcc/files/child_care_tips_booklet.pdf',
                                'children' => [],
                                'target'=>'_blank'
                            ],
                            [
                                'title' => __('GOVHK香港政府一站通親職教育'),
                                'url' => 'https://www.gov.hk/tc/residents/health/childhealth/parenting.htm',
                                'children' => [],
                                'target'=>'_blank'
                            ]
                        ]
                    ]
                ]
            ];

            $navs[] = [
                'title' => __(' 專業學習社群'),
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

        $title = __('赛马会幼儿「喜步」计划');


        View::share('title', $title);

        return $next($request);
    }
}
