<?php

namespace App\Http\Controllers\Web;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\MessageRequest;
use App\Models\Message;
use App\Models\News\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AboutUsController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $institutions = [
            "女青喜越嬰幼園",
            "仁濟醫院艾王忠椒育嬰園",
            "東華三院譚鑑標悅樂園",
            "保良局莫慶堯育嬰園",
            "香港基督教女青年會喜越嬰幼園(皇后山)",
            "香港基督教服務處雋日幼兒園(大埔)",
            "香港基督教服務處雋日幼兒園(深水埗)",
            "香港聖公會深水埗幼兒中心",
            "香港聖公會麥理浩夫人中心趣智成長樂園",
            "香港聖公會聖多馬幼兒中心",
            "基督教香港崇真會恩樂園",
            "基督教香港崇真會恩樂園(葵芳)",
            "聖公會聖基道兒童院愛幼坊",
            "鄰舍輔導會友愛育嬰園",
            "鄰舍輔導會新翠育嬰園"
        ];

        $institutions = array_chunk($institutions, ceil(count($institutions) / 2));

        return view('web.v1.about-us', compact('institutions'));
    }
}
