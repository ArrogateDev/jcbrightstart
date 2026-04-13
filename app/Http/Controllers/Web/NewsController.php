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
        $articles = News::query()
            ->where('type', News::TYPE_ARTICLE)
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('id')
            ->limit(7)
            ->select('id', 'title', 'thumbnail', 'category_id', 'short', 'created_at')
            ->get();

        $articles->map(function ($item) {
            $item->url = route('resource.show.html', ['resource' => $item->id]);
        });
        $articles->append(['category_text']);

        $total_article = News::query()
            ->where('type', News::TYPE_ARTICLE)
            ->where('status', News::STATUS_PUBLISHED)
            ->count();

        $videos = News::query()
            ->where('type', News::TYPE_VIDEO)
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('id')
            ->limit(7)
            ->select('id', 'title', 'thumbnail', 'category_id', 'short', 'created_at')
            ->get();

        $videos->map(function ($item) {
            $item->url = route('resource.show.html', ['resource' => $item->id]);
        });
        $videos->append(['category_text']);

        $total_video = News::query()
            ->where('type', News::TYPE_VIDEO)
            ->where('status', News::STATUS_PUBLISHED)
            ->count();

        $url = $request->fullUrl();
        $request->session()->put('resource-url', $url);

        return view('web.news.index', compact('articles', 'total_article', 'videos', 'total_video'));
    }

    /**
     * Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function more(Request $request)
    {
        $type = (int)$request->query('type', 1);
        $categories = NewsCategory::query()
            ->where('status', 0)
            ->select('id', 'title')
            ->get();

        $subtitle = $type > 0 ? __('最新消息') : __('视频');

        $url = $request->fullUrl();
        $request->session()->put('resource-url', $url);

        return view('web.news.more', compact('subtitle', 'type', 'categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $keywords = $request->query('keywords');
        $category = (int)$request->query('category');
        $type = (int)$request->query('type', 0);
        $now = Carbon::now()->toDateString();
        $params = [
            'keywords' => $keywords,
            'category' => $category,
            'type' => $type,
        ];

        $list = News::query()
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('title', 'like', '%' . $keywords . '%');
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->where('type', $type)
//            ->when($type === 1, function ($query) use ($now) {
//                $query->where('release_date', '>=', $now);
//            }, function ($query) use ($now) {
//                $query->where('release_date', '<', $now);
//            })
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->select('id', 'title', 'thumbnail', 'short', 'release_date')
            ->paginate(12);

        $list->appends($params);

        $list->map(function ($item) {
            $item->url = route('news.show.html', ['news' => $item->id]);
        });

        $html = '';

        $total = $list->count();
        $page = $list->currentPage();
        $data = $list->items();
        $col_num = 3;
        foreach ($data as $news) {
            $html .= view('web.news.item', compact('news', 'col_num'))->render();
        }

        $pagination = $total > 0 ? $list->links('components.web.pagination')->toHtml() : '';

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
            ->orderByDesc('sort')
            ->orderBy('id', 'desc')
            ->value('id');

        $next = News::query()
            ->where('id', '>', $news->id)
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('sort')
            ->orderBy('id', 'asc')
            ->value('id');

        $url = $request->session()->get('resource-url');

        return view(sprintf('web.news.show%s', $news->type === News::TYPE_VIDEO ? '-video' : ''), compact('news', 'prev', 'next', 'url'));
    }
}
