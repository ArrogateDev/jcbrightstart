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
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $category = NewsCategory::query()
            ->where('status', 0)
            ->select('id', 'title')
            ->get();

        $url = $request->fullUrl();
        $request->session()->put('resource-url', $url);

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
        $now = Carbon::now()->toDateString();

        $list = News::query()
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('title', 'like', '%' . $keywords . '%');
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->when($type === 1, function ($query) use ($now) {
                $query->where('release_date', '>=', $now);
            }, function ($query) use ($now) {
                $query->where('release_date', '<', $now);
            })
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('id')
            ->select('id', 'title', 'thumbnail', 'short', 'release_date')
            ->paginate(12);

        $list->map(function ($item) {
            $item->url = route('news.show.html', ['news' => $item->id]);
        });

        $html = '';

        $total = $list->count();
        $page = $list->currentPage();
        $data = $list->items();
        foreach ($data as $news) {
            $html .= view('web.news.item', compact('news'))->render();
        }

        $pagination = $total > 0 ? $list->links('components.web.pagination')->toHtml() : '';

        $url = $request->fullUrl();
        $request->session()->put('resource-url', $url);

        return $this->responseSuccess(compact('html', 'total', 'page', 'pagination'));
    }

    /**
     * News $news
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(News $news, Request $request)
    {

        $date = Carbon::parse($news->created_at);
        $news->month = $date->format('M');
        $news->day = $date->format('d');

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

        $url = $request->session()->get('resource-url');

        return view('web.news.show', compact('news', 'prev', 'next', 'url'));
    }
}
