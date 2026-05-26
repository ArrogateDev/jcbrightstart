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
use Illuminate\Support\Str;

class ResourceController extends Controller
{

    /**
     * Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $url = $request->path();
        $view = Str::replace(['/', '.html'], ['-', ''], $url);

        $categories = ResourceCategory::query()
            ->when($view === 'resource-kit', function ($query) {
                $query->where('pid', 16);
            })
            ->when($view === 'resource-kit-share', function ($query) {
                $query->where('pid', 14);
            })
            ->where('status', 0)
            ->select('id', 'title')
            ->get();

        return view('web.resource.' . $view, compact('categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $type = (int)$request->query('type');
        $keywords = $request->query('keywords');
        $mod = (int)$request->query('mod');
        $category = (int)$request->query('category');
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
            ->when($mod, function ($query) use ($mod) {
                $query->where('category_top_id', $mod);
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
            $item->date = Carbon::parse($item->created_at)->format('Y.m.d');
            $item->url = route('resource.show.html', ['resource' => $item->id]);
        });
        $list->append(['category_top_text', 'category_text']);

        $html = '';

        $template = '01';
        $mod === 16 && $template = '02';
        $type === Resource::TYPE_VIDEO && $template = '03';

        $total = $list->count();
        $page = $list->currentPage();
        $data = $list->items();
        foreach ($data as $resource) {
            $html .= view(sprintf('web.resource.item-%s', $template), compact('resource'))->render();
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
        $resource->date = $date->format('Y.m.d');

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

        $view = '01';
        $resource->category_top_id === 16 && $view = '02';
        $resource->type === Resource::TYPE_VIDEO && $view = '03';

        return view(sprintf('web.resource.show-%s', $view), compact('resource', 'prev', 'next', 'url'));
    }
}
