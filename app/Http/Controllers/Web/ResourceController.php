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
        $category = ResourceCategory::query()
            ->where('status', 0)
            ->select('id', 'title')
            ->get();

        $new_resource = Resource::query()
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('id')
            ->first();

        $new_resource && $new_resource->url = route('resource.show.html', ['resource' => $new_resource->id]);
        $new_resource && $new_resource->append(['category_text']);
        $request->session()->put('resource_new', $new_resource->id ?? 0);

        return view('web.resource.index', compact('category', 'new_resource'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $new_resource_id = $request->session()->get('resource_new');
        $keywords = $request->query('keywords');
        $category = $request->query('category');
        $sort = $request->query('sort', 'time');

        $list = Resource::query()
            ->when($new_resource_id > 0, function ($query) use ($new_resource_id) {
                $query->whereNotIn('id', [$new_resource_id]);
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
            $html .= view('web.resource.item', compact('resource'))->render();
        }

        $pagination = $total > 0 ? $list->links('components.web.pagination')->toHtml() : '';

        return $this->responseSuccess(compact('html', 'total', 'page', 'pagination'));
    }

    /**
     * Resource $resource
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Resource $resource)
    {

        $date = Carbon::parse($resource->created_at);
        $resource->month = $date->format('M');
        $resource->day = $date->format('d');

        $prev = Resource::query()
            ->where('id', '<', $resource->id)
            ->where('status', Resource::STATUS_PUBLISHED)
            ->orderBy('id')
            ->value('id');

        $next = Resource::query()
            ->where('id', '>', $resource->id)
            ->where('status', Resource::STATUS_PUBLISHED)
            ->orderBy('id')
            ->value('id');

        return view('web.resource.show', compact('resource', 'prev', 'next'));
    }
}
