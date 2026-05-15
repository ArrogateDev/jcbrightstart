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
        $news = News::query()
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('release_date')
            ->orderByDesc('sort')
            ->limit(15)
            ->select('id', 'title', 'release_date')
            ->get();

        $news->map(function ($item) {
            $date = Carbon::parse($item->release_date);
            $item->date = $date->format('Y.m.d');
            $item->url = route('news.show.html', ['news' => $item->id]);
        });

        return view('web.index', compact('news'));
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
}
