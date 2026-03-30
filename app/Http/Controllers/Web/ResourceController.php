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


        $url = $request->fullUrl();
        $request->session()->put('resource-url', $url);

        return view('web.resource.index', compact('articles', 'videos'));
    }

    /**
     * Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function more(Request $request)
    {
        $type = (int)$request->query('type');

        $category = ResourceCategory::query()
            ->where('status', 0)
            ->select('id', 'title')
            ->get();

        $url = $request->fullUrl();
        $request->session()->put('resource-url', $url);

        return view('web.resource.more', compact('category', 'type'));
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
                $query->orderByDesc('id');
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

        $url = $request->fullUrl();
        $request->session()->put('resource-url', $url);

        return $this->responseSuccess(compact('html', 'total', 'page', 'pagination', 'url'));
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
            ->orderBy('id', 'desc')
            ->value('id');

        $next = Resource::query()
            ->where('id', '>', $resource->id)
            ->where('status', Resource::STATUS_PUBLISHED)
            ->orderBy('id', 'asc')
            ->value('id');

        $url = $request->session()->get('resource-url');

        return view(sprintf('web.resource.show%s', $resource->type === Resource::TYPE_VIDEO ? '-video' : ''), compact('resource', 'prev', 'next', 'url'));
    }
}
