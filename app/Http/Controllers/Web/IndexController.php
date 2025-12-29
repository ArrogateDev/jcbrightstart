<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{

    public function index()
    {
        $now = Carbon::now()->toDateTimeString();
        $news = News::query()
            ->where(DB::raw("CONCAT(`end_date`, ' ', `end_time`)"), '>', $now)
            ->where('status', News::STATUS_PUBLISHED)
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $news->map(function ($item) {
            $date = Carbon::parse($item->created_at);
            $item->month = $date->format('M');
            $item->day = $date->format('d');
            $item->url = route('news.show.html', ['news' => $item->id]);
        });

        $news->append(['event_date_text', 'event_time_text']);

        return view('web.index', compact('news'));
    }

    public function other(int $no = 2)
    {
        $no = $no > 6 ? 2 : $no;
        $no = $no < 2 ? 2 : $no;

        return view('web.index-' . $no);
    }

}
