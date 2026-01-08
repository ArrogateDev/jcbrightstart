<?php

namespace App\Models\News;

use App\Models\Base;

class NewsCategory extends Base
{
    const STATUS_PUBLISHED = 2;

    const STATUS_SUSPENSED = 1;

    const STATUS_DRAFT = 0;
}
