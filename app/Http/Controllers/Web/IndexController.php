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

class IndexController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $user = $request->user('web');
        $banners = [
            [
                'title' => __('香港0-3岁婴幼儿服务资讯'),
                'bg' => web_resource_url('assets/img/service-information.png'),
                'url' => route('maps.html'),
                'col' => 4
            ],
            [
                'title' => __('专业学习社群'),
                'bg' => web_resource_url('assets/img/professional-learning-community.png'),
                'url' => route('news.html'),
                'col' => 4
            ],
            [
                'title' => __('家长学习平台'),
                'bg' => web_resource_url('assets/img/parent-learning-platform.png'),
                'url' => route($user ? 'user.dashboard.html' : 'login.html'),
                'col' => 4
            ]
        ];

        $news_banners = News::query()
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('id')
            ->limit(5)
            ->select('id', 'title', 'thumbnail')
            ->get();
        $news_banners->map(function ($item) {
            $item->url = route('news.show.html', ['news' => $item->id]);
        });

        $news = News::query()
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('release_date')
            ->orderByDesc('sort')
            ->limit(3)
            ->get();

        $news->map(function ($item) {
            $date = Carbon::parse($item->created_at);
            $item->month = $date->format('M');
            $item->day = $date->format('d');
            $item->url = route('news.show.html', ['news' => $item->id]);
        });

        $news->append(['event_date_text', 'event_time_text']);

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

        return view('web.index', compact('news_banners', 'banners', 'institutions', 'news'));
    }


    public function handleMessage(MessageRequest $request)
    {
        $user = $request->user('web');
        $ip = $request->ip();
        $key = $user->id ?? $request->ip();
        if (!(($lock = Cache::lock("submit_message_lock:$key", 360))->get())) {
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['name', 'email', 'message']);

        try {

            $message = new Message();
            foreach ($inputs as $key => $value) {
                $message->$key = $value;
            }
            $message->user_id = $user->id ?? 0;
            $message->ip = $ip;

            if ($message->save() === false) {
                throw new \Exception('message:failed', ResponseCode::SERVER_ERR);
            }

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    public function v1Index(Request $request)
    {
        $news = News::query()
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('release_date')
            ->orderByDesc('sort')
            ->limit(15)
            ->select('id', 'title')
            ->get();

        $news->map(function ($item) {
            $date = Carbon::parse($item->created_at);
            $item->date = $date->format('Y.M.d');
            $item->url = route('news.show.html', ['news' => $item->id]);
        });

        return view('web.v1.index', compact('news'));
    }
}
