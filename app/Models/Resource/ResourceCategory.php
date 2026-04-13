<?php

namespace App\Models\Resource;

use App\Models\Base;

class ResourceCategory extends Base
{
    const STATUS_PUBLISHED = 2;

    const STATUS_SUSPENSED = 1;

    const STATUS_DRAFT = 0;

    public function parent()
    {
        return $this->belongsTo(ResourceCategory::class, 'pid');
    }

    public function getParentTextAttribute()
    {
        return $this->parent ? $this->parent->title : __('最上級');
    }
}
