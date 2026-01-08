<?php

namespace App\Models\News;

use App\Models\Base;
use Carbon\Carbon;

class News extends Base
{
    const STATUS_PUBLISHED = 2;

    const STATUS_SUSPENSED = 1;

    const STATUS_DRAFT = 0;

    /**
     * @param $value
     * @return string
     */
    public function getThumbnailAttribute($value)
    {
        return $value ? web_resource_url($value) : web_resource_url('assets/img/fill.png');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    /**
     * @return string
     */
    public function getCategoryTextAttribute()
    {
        return $this->category->title ?? '';
    }

    /**
     * @return string
     */
    public function getEventDateTextAttribute()
    {
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        if ($start_date->eq($end_date)) {
            $text = $start_date->format('d/m/Y(D)');
        } else {
            $text = $start_date->format('d/m/Y(D)') . ' - ' . $end_date->format('d/m/Y(D)');
        }
        return $text;
    }

    /**
     * @return string
     */
    public function getEventTimeTextAttribute()
    {
        $start_time = Carbon::parse($this->start_time);
        $end_time = Carbon::parse($this->end_time);
        if ($start_time->eq($end_time)) {
            $text = $start_time->format('H:i A');
        } else {
            $text = $start_time->format('H:i A') . ' - ' . $end_time->format('H:i A');
        }
        return $text;
    }
}
