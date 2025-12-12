<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index()
    {
        $all = Course::query()->where('status', Course::STATUS_PUBLISHED)->count() ?? 0;
        $active = 0;
        $completed = 0;

        $all = $all > 0 ? str_pad($all, 2, 0, STR_PAD_LEFT) : 0;
        $active = $active > 0 ? str_pad($active, 2, 0, STR_PAD_LEFT) : 0;
        $completed = $completed > 0 ? str_pad($completed, 2, 0, STR_PAD_LEFT) : 0;

        return view('web.user.course.list', compact('all', 'active', 'completed'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $keywords = $request->query('keywords');
        $status = $request->query('status');

        $list = Course::query()
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('title', 'like', '%' . $keywords . '%');
            })
            ->when($status > 0, function ($query) use ($status) {
                $query->where('status', 999);
            })
            ->where('status', Course::STATUS_PUBLISHED)
            ->paginate(18);

        $html = '';

        $total = $list->count();
        $page = $list->currentPage();
        $data = $list->items();
        foreach ($data as $course) {
            $html .= view('web.user.course.course', compact('course'))->render();
        }

        return $this->responseSuccess(compact('html', 'total', 'page'));
    }
}
