<?php

namespace App\Http\Controllers\Web;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\MessageRequest;
use App\Models\Message;
use App\Models\News;
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
                'title' => __('最新消息'),
                'bg' => web_resource_url('assets/web/images/our-class-11.jpg'),
                'url' => route('news.html'),
                'col' => 8
            ],
            [
                'title' => __('香港0-3岁婴幼儿服务资讯'),
                'bg' => web_resource_url('assets/web/images/our-class-11.jpg'),
                'url' => route('maps.html'),
                'col' => 4
            ],
            [
                'title' => __('专业学习社群'),
                'bg' => web_resource_url('assets/web/images/our-class-11.jpg'),
                'url' => route('news.html'),
                'col' => 4
            ],
            [
                'title' => __('家长学习平台'),
                'bg' => web_resource_url('assets/web/images/our-class-11.jpg'),
                'url' => route($user ? 'user.dashboard.html' : 'login.html'),
                'col' => 8
            ]
        ];

        $now = Carbon::now()->toDateTimeString();
        $news = News::query()
            ->where(DB::raw("CONCAT(`end_date`, ' ', `end_time`)"), '>', $now)
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $news->map(function ($item) {
            $date = Carbon::parse($item->created_at);
            $item->month = $date->format('M');
            $item->day = $date->format('d');
            $item->url = route('news.show.html', ['news' => $item->id]);
        });

        $news->append(['event_date_text', 'event_time_text']);

        return view('web.index', compact('banners', 'news'));
    }


    public function handleMessage(MessageRequest $request)
    {
        $user = $request->user('web');
        $ip = $request->ip();
        $key = $user->id ?? $request->ip();
        if (!(($lock = Cache::lock("submit_message_lock:$key", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
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
}
