<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ServiceLocation;
use App\Models\ServiceLocationType;

class MapsController extends Controller
{

    public function index()
    {
        return view('web.under-construction');
        $maps = ServiceLocationType::query()
            ->with([
                'locations' => function ($query) {
                    $query->where('status', ServiceLocation::NORMAL)
                        ->orderByDesc('sort')
                        ->select('id', 'type', 'age', 'district', 'organization', 'address', 'phone', 'email', 'webpage', 'service_hour', 'longitude', 'point_color', 'latitude');
                }
            ])
            ->where('status', ServiceLocationType::NORMAL)
            ->orderByDesc('sort')
            ->select('id', 'title')
            ->get();

        $colors = [
            '香港幼兒中心' => [
                'bg' => '#f8f4e5',
                'point' => '#fce7e5',
                'icon' => web_resource_url('assets/web/images/maps/icon-02.svg')
            ],
            '鄰里支援幼兒照顧計劃' => [
                'bg' => '#fce7e5',
                'point' => '#915da3',
                'icon' => web_resource_url('assets/web/images/maps/icon-03.svg')
            ]
        ];
        $maps->map(function ($item) use ($colors) {
            $color = $colors[$item->title] ?? [];
            $item->bg = $color['bg'] ?? '#f8f4e5';
            $item->point = $color['point'] ?? '#fce7e5';
            $item->icon = $color['icon'] ?? web_resource_url('assets/web/images/maps/icon-01.svg');
        });

        $urls = [
            [
                'title' => __('社会福利署幼儿中心'),
                'url' => 'https://www.swd.gov.hk/tc/pubsvc/family/cat_childcareservice/daychildcares/cccs/index.html'
            ],
            [
                'title' => __('受资助及私营／非牟利的独立幼儿中心名单及电话'),
                'url' => 'https://www.swd.gov.hk/storage/asset/section/644/tc/Child_Care_Centre_cccai_as_at_2025-07-25.pdf'
            ],
            [
                'title' => __('邻里支援幼儿照顾计划'),
                'url' => 'https://www.swd.gov.hk/tc/pubsvc/family/cat_childcareservice/daychildcares/nsccp/index.html'
            ],
            [
                'title' => __('“日间幼儿照顾服务”服务单张'),
                'url' => 'https://www.swd.gov.hk/storage/asset/section/264/tc/Day%20Child%20Care%20Services%20Leaflet_TradChi%26Eng_Sept%2024.pdf'
            ],
            [
                'title' => __('母婴健康院'),
                'url' => 'https://www.fhs.gov.hk/tc_chi/centre_det/maternal/maternal.html'
            ],
            [
                'title' => __('接种疫苗'),
                'url' => 'https://www.fhs.gov.hk/tc_chi/health_info/child/14828.html'
            ],
            [
                'title' => __('新生婴儿奖励金'),
                'url' => 'https://www.cso.gov.hk/newbornbabybonus/chi/index.htm'
            ],
            [
                'title' => __('儿童健康攻略'),
                'url' => 'https://www.healthbureau.gov.hk/phcc/files/child_care_tips_booklet.pdf'
            ],
            [
                'title' => __('GOVHK香港政府一站通亲职教育'),
                'url' => 'https://www.gov.hk/tc/residents/health/childhealth/parenting.htm'
            ]
        ];
        $urls = [];

        return view('web.maps', compact('maps', 'urls'));
    }

    public function list()
    {
        return view('web.under-construction');
        $maps = ServiceLocationType::query()
            ->with([
                'locations' => function ($query) {
                    $query->where('status', ServiceLocation::NORMAL)
                        ->orderByDesc('sort')
                        ->select('id', 'type', 'age', 'district', 'organization', 'address', 'phone', 'email', 'webpage', 'service_hour', 'longitude', 'point_color', 'latitude');
                }
            ])
            ->where('status', ServiceLocationType::NORMAL)
            ->orderByDesc('sort')
            ->select('id', 'title')
            ->get();

        $colors = [
            '香港幼兒中心' => [
                'bg' => '#f8f4e5',
                'point' => '#fce7e5',
                'icon' => web_resource_url('assets/web/images/maps/icon-02.svg'),
                'iBg' => '#fffbed',
                'iTag' => '#ffefb5',
                'iText' => '#8c6139',
                'iLine' => '#c7b299',
                'iDogEar' => '#fff3c3'
            ],
            '鄰里支援幼兒照顧計劃' => [
                'bg' => '#fce7e5',
                'point' => '#915da3',
                'icon' => web_resource_url('assets/web/images/maps/icon-03.svg'),
                'iBg' => '#f5f0f3',
                'iTag' => '#e8e1e6',
                'iText' => '#8c6139',
                'iLine' => '#e7caca',
                'iDogEar' => '#fff3c3'
            ]
        ];
        $maps->map(function ($item) use ($colors) {
            $color = $colors[$item->title] ?? [];
            $item->bg = $color['bg'] ?? '#f8f4e5';
            $item->point = $color['point'] ?? '#fce7e5';
            $item->icon = $color['icon'] ?? web_resource_url('assets/web/images/maps/icon-01.svg');
            $item->i_bg = $color['iBg'] ?? '#f5f0f3';
            $item->i_tag = $color['iTag'] ?? '#e8e1e6';
            $item->i_text = $color['iText'] ?? '#915da3';
            $item->i_line = $color['iLine'] ?? '#e7caca';
        });

        return view('web.maps-list', compact('maps'));
    }

    public function link()
    {
        return view('web.under-construction');
        $urls = [
            [
                'title' => __('社会福利署幼儿中心'),
                'url' => 'https://www.swd.gov.hk/tc/pubsvc/family/cat_childcareservice/daychildcares/cccs/index.html'
            ],
            [
                'title' => __('受资助及私营／非牟利的独立幼儿中心名单及电话'),
                'url' => 'https://www.swd.gov.hk/storage/asset/section/644/tc/Child_Care_Centre_cccai_as_at_2025-07-25.pdf'
            ],
            [
                'title' => __('邻里支援幼儿照顾计划'),
                'url' => 'https://www.swd.gov.hk/tc/pubsvc/family/cat_childcareservice/daychildcares/nsccp/index.html'
            ],
            [
                'title' => __('“日间幼儿照顾服务”服务单张'),
                'url' => 'https://www.swd.gov.hk/storage/asset/section/264/tc/Day%20Child%20Care%20Services%20Leaflet_TradChi%26Eng_Sept%2024.pdf'
            ],
            [
                'title' => __('母婴健康院'),
                'url' => 'https://www.fhs.gov.hk/tc_chi/centre_det/maternal/maternal.html'
            ],
            [
                'title' => __('接种疫苗'),
                'url' => 'https://www.fhs.gov.hk/tc_chi/health_info/child/14828.html'
            ],
            [
                'title' => __('新生婴儿奖励金'),
                'url' => 'https://www.cso.gov.hk/newbornbabybonus/chi/index.htm'
            ],
            [
                'title' => __('儿童健康攻略'),
                'url' => 'https://www.healthbureau.gov.hk/phcc/files/child_care_tips_booklet.pdf'
            ],
            [
                'title' => __('GOVHK香港政府一站通亲职教育'),
                'url' => 'https://www.gov.hk/tc/residents/health/childhealth/parenting.htm'
            ]
        ];

        return view('web.maps-link', compact('urls'));
    }
}
