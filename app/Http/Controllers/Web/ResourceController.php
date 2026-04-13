<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\News\News;
use App\Models\News\NewsCategory;
use App\Models\Resource\Resource;
use App\Models\Resource\ResourceCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResourceController extends Controller
{

    /**
     * Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $articles = Resource::query()
            ->where('type', Resource::TYPE_ARTICLE)
            ->where('status', Resource::STATUS_PUBLISHED)
            ->orderByDesc('id')
            ->limit(7)
            ->select('id', 'title', 'thumbnail', 'category_id', 'short', 'created_at')
            ->get();

        $articles->map(function ($item) {
            $item->url = route('resource.show.html', ['resource' => $item->id]);
        });
        $articles->append(['category_text']);

        $total_article = Resource::query()
            ->where('type', Resource::TYPE_ARTICLE)
            ->where('status', Resource::STATUS_PUBLISHED)
            ->count();

        $videos = Resource::query()
            ->where('type', Resource::TYPE_VIDEO)
            ->where('status', Resource::STATUS_PUBLISHED)
            ->orderByDesc('id')
            ->limit(7)
            ->select('id', 'title', 'thumbnail', 'category_id', 'short', 'created_at')
            ->get();

        $videos->map(function ($item) {
            $item->url = route('resource.show.html', ['resource' => $item->id]);
        });
        $videos->append(['category_text']);

        $total_video = Resource::query()
            ->where('type', Resource::TYPE_VIDEO)
            ->where('status', Resource::STATUS_PUBLISHED)
            ->count();

        $url = $request->fullUrl();
        $request->session()->put('resource-url', $url);

        return view('web.resource.index', compact('articles', 'total_article', 'videos', 'total_video'));
    }

    /**
     * Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function more(Request $request)
    {
        $type = (int)$request->query('type');
        $category = (int)$request->query('mod');

        $categories = ResourceCategory::query()
            ->where('pid', $category)
            ->where('status', 0)
            ->select('id', 'title')
            ->get();

        $subtitle = $category > 0 ? ResourceCategory::query()->where('id', $category)->value('title') : __('视频');

        $url = $request->fullUrl();
        $request->session()->put('resource-url', $url);

        return view('web.resource.more', compact('subtitle', 'categories', 'type'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $type = (int)$request->query('type');
        $keywords = $request->query('keywords');
        $category = $request->query('category');
        $sort = $request->query('sort', 'time');

        $list = Resource::query()
            ->when($type === Resource::TYPE_VIDEO, function ($query) {
                $query->where('type', Resource::TYPE_VIDEO);
            }, function ($query) {
                $query->where('type', Resource::TYPE_ARTICLE);
            })
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('title', 'like', '%' . $keywords . '%');
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->when($sort === 'view', function ($query) use ($category) {
                $query->orderByDesc('view');
            }, function ($query) {
                $query->orderByDesc('sort')->orderByDesc('id');
            })
            ->where('status', News::STATUS_PUBLISHED)
            ->paginate(12);

        $list->map(function ($item) {
            $item->url = route('resource.show.html', ['resource' => $item->id]);
        });
        $list->append(['category_text']);

        $html = '';

        $total = $list->count();
        $page = $list->currentPage();
        $data = $list->items();
        foreach ($data as $resource) {
            $html .= view(sprintf('web.resource.item%s', $resource->type === Resource::TYPE_VIDEO ? '-video' : ''), compact('resource'))->render();
        }

        $pagination = $total > 0 ? $list->links('components.web.pagination')->toHtml() : '';

        return $this->responseSuccess(compact('html', 'total', 'page', 'pagination'));
    }

    /**
     * Resource $resource
     *
     * @param Resource $resource
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Resource $resource, Request $request)
    {

        $date = Carbon::parse($resource->created_at);
        $resource->month = $date->format('M');
        $resource->day = $date->format('d');

        $prev = Resource::query()
            ->where('id', '<', $resource->id)
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('sort')
            ->orderBy('id', 'desc')
            ->value('id');

        $next = Resource::query()
            ->where('id', '>', $resource->id)
            ->where('status', Resource::STATUS_PUBLISHED)
            ->orderByDesc('sort')
            ->orderBy('id', 'asc')
            ->value('id');

        $url = $request->session()->get('resource-url');

        return view(sprintf('web.resource.show%s', $resource->type === Resource::TYPE_VIDEO ? '-video' : ''), compact('resource', 'prev', 'next', 'url'));
    }
}
