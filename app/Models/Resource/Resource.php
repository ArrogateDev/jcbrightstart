<?php

namespace App\Models\Resource;

use App\Models\Base;

class Resource extends Base
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
        return $this->belongsTo(ResourceCategory::class, 'category_id');
    }

    /**
     * @return string
     */
    public function getCategoryTextAttribute()
    {
        return $this->category->title ?? '';
    }
}
