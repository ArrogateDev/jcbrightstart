<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\News\News;
use App\Models\News\NewsCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $category = NewsCategory::query()
            ->where('status', 0)
            ->select('id', 'title')
            ->get();

        return view('web.news.index', compact('category'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $keywords = $request->query('keywords');
        $category = $request->query('category');
        $type = (int)$request->query('type', 1);
        $now = Carbon::now()->toDateTimeString();

        $list = News::query()
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('title', 'like', '%' . $keywords . '%');
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->when($type === 1, function ($query) use ($now) {
                $query->where(DB::raw("CONCAT(`end_date`, ' ', `end_time`)"), '>', $now);
            }, function ($query) use ($now) {
                $query->where(DB::raw("CONCAT(`end_date`, ' ', `end_time`)"), '<=', $now);
            })
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('id')
            ->paginate(12);

        $list->map(function ($item) {
            $date = Carbon::parse($item->created_at);
            $item->month = $date->format('M');
            $item->day = $date->format('d');
            $item->url = route('news.show.html', ['news' => $item->id]);
        });

        $list->append(['event_date_text', 'event_time_text']);

        $html = '';

        $total = $list->count();
        $page = $list->currentPage();
        $data = $list->items();
        foreach ($data as $news) {
            $html .= view('web.news.item', compact('news'))->render();
        }

        $pagination = $total > 0 ? $list->links('components.web.pagination')->toHtml() : '';

        return $this->responseSuccess(compact('html', 'total', 'page', 'pagination'));
    }

    /**
     * News $news
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(News $news)
    {

        $date = Carbon::parse($news->created_at);
        $news->month = $date->format('M');
        $news->day = $date->format('d');
        $news->append(['event_date_text', 'event_time_text']);

        $prev = News::query()
            ->where('id', '<', $news->id)
            ->where('status', News::STATUS_PUBLISHED)
            ->orderBy('id')
            ->value('id');

        $next = News::query()
            ->where('id', '>', $news->id)
            ->where('status', News::STATUS_PUBLISHED)
            ->orderBy('id')
            ->value('id');

        return view('web.news.show', compact('news', 'prev', 'next'));
    }
}
