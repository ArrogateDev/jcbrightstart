<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\News\News;
use App\Models\News\NewsCategory;
use App\Models\Resource\Resource;
use App\Models\Resource\ResourceCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResourceController extends Controller
{


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('web.under-construction');
        $c = (int)$request->query('c');
        $n = (int)$request->query('n');
        if (empty($c) || empty($n)) {
            abort(404);
        }

        $category = Cache::tags(['RESOURCE_CATEGORY'])->rememberForever('CATEGORY:' . $c, function () use ($c) {
            return ResourceCategory::query()
                ->where('id', $c)
                ->select('id', 'title', 'pid', 'url', 'template')
                ->first();
        });

        $view = Str::replace(['.html', '.', 'resource'], ['', '-', 'resource-kit'], $category->url);

        $breadcrumbs = [];

        return view('web.resource.' . $view, compact('breadcrumbs', 'category'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $c = (int)$request->query('c');
        $n = (int)$request->query('n');
        $sort = $request->query('sort', 'time');

        if (empty($c) || empty($n)) {
            $html = '';
            $total = 0;
            $page = 1;
            $pagination = '';
            return $this->responseSuccess(compact('html', 'total', 'page', 'pagination'));
        }

        $category = Cache::tags(['RESOURCE_CATEGORY'])->rememberForever('CATEGORY:' . $c, function () use ($c) {
            return ResourceCategory::query()
                ->where('id', $c)
                ->select('id', 'title', 'pid', 'url', 'template')
                ->first();
        });

        $params['c'] = $c;
        $params['n'] = $n;

        $limit = 12;

        $list = Resource::query()
            ->with(['category_top:id,title,color', 'category:id,title,color'])
            ->whereHasIn('categories', function ($query) use ($c) {
                $query->whereIn('id', [$c]);
            })
            ->when($sort === 'view', function ($query) {
                $query->orderByDesc('view');
            }, function ($query) {
                $query->orderByDesc('sort')->orderByDesc('id');
            })
            ->where('status', News::STATUS_PUBLISHED)
            ->paginate($limit);

        $list->appends([...$params, 'limit' => $limit]);

        $list->map(function ($item) {
//            $item->date = Carbon::parse($item->created_at)->format('Y.m.d');
            $item->url = route('resource.show.html', ['resource' => $item->id]);
        });
        $list->append(['category_top_text', 'category_top_color', 'category_text', 'category_color']);

        $html = '';

        $template = $category->template;
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
        return view('web.under-construction');
        $category = DB::table('resource_categories as child')
            ->leftJoin('resource_categories as parent', 'parent.id', '=', 'child.pid')
            ->where('child.id', $resource->category_id)
            ->whereNull('child.deleted_at')
            ->whereNull('parent.deleted_at')
            ->select([
                'parent.id as parent_id',
                'parent.level as parent_level',
            ])
            ->first();

        $c = ($category && $category->parent_level == 2)
            ? $category->parent_id
            : $resource->category_id;

        $date = Carbon::parse($resource->created_at);
        $resource->month = $date->format('M');
        $resource->day = $date->format('d');
        $resource->date = $date->format('Y.m.d');

        $prev = Resource::query()
            ->when($c, function ($query) use ($c) {
                $query->whereHasIn('categories', function ($query) use ($c) {
                    $query->whereIn('id', [$c]);
                });
            })
            ->where('status', Resource::STATUS_PUBLISHED)
            ->where(function ($query) use ($resource) {
                $query->where('sort', '>', $resource->sort)
                    ->orWhere(function ($query) use ($resource) {
                        $query->where('sort', $resource->sort)
                            ->where('id', '>', $resource->id);
                    });
            })
            ->orderBy('sort')
            ->orderBy('id')
            ->value('id');

        $next = Resource::query()
            ->when($c, function ($query) use ($c) {
                $query->whereHasIn('categories', function ($query) use ($c) {
                    $query->whereIn('id', [$c]);
                });
            })
            ->where('status', Resource::STATUS_PUBLISHED)
            ->where(function ($query) use ($resource) {
                $query->where('sort', '<', $resource->sort)
                    ->orWhere(function ($query) use ($resource) {
                        $query->where('sort', $resource->sort)
                            ->where('id', '<', $resource->id);
                    });
            })
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->value('id');

        $url = $request->session()->get('resource-url');

        $view = '01';
        !empty($resource->pdf) && $view = '02';
        $resource->type === Resource::TYPE_VIDEO && $view = '03';

        $breadcrumbs = [
            [
                'title' => $view === '01' ? __('知識庫') : __('專業學習社群'),
                'url' => null,
                'color' => '#666666',
            ],
            [
                'title' => $resource->title,
                'url' => null,
                'color' => '#00A99D',
            ]
        ];

        return view(sprintf('web.resource.show-%s', $view), compact('breadcrumbs', 'resource', 'prev', 'next', 'url'));
    }
}
