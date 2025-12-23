<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        //开始课程
        $start_course = 0;
        //完成课程
        $complete_course = 0;
        //完成测验
        $complete_quizzes = 0;
        //家长总数
        $parents = User::query()->count();
        //课程总数
        $total_courses = Course::query()->where('status', Course::STATUS_PUBLISHED)->count();
        //证书总数
        $certificates = 0;

        $courses = Course::query()
            ->select('id', 'title', 'thumbnail', 'status', 'created_at')
            ->limit(5)
            ->orderByDesc('id')
            ->get();

        $result = compact('start_course', 'complete_course', 'complete_quizzes', 'parents', 'total_courses', 'certificates', 'courses');

        return view('admin.dashboard', $result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $end = Carbon::parse($end ?? now())->endOfDay();
        $start = Carbon::parse($start ?? $end->clone()->subMonth())->startOfDay();

        $x_axis = [];
        $x_axis_object = [];
        $is_month = $start->diffInDays($end) > 31;
        $period = $is_month ? $start->copy()->monthsUntil($end) : $start->copy()->daysUntil($end);
        foreach ($period as $value) {
            $x_axis[] = $value->format($is_month ? 'M' : 'd/m');
            $x_axis_object [] = $value;
        }

        $result['data'] = [];
        $result['x_axis'] = $x_axis;

        $users = User::query()
            ->when($is_month, function ($query) {
                $query->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as date"), DB::raw('COUNT(*) as count'));
            }, function ($query) {
                $query->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'));
            })
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        foreach ($x_axis_object as $x) {
            $x_string = Carbon::parse($x)->format($is_month ? 'Y-m' : 'Y-m-d');
            $result['data'][] = $users[$x_string] ?? 0;
        }

        return $this->responseSuccess($result);
    }
}
