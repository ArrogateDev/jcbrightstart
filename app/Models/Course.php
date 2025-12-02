<?php

namespace App\Models;

class Course extends Base
{

    /**
     * @param $value
     * @return string
     */
    public function getThumbnailAttribute($value)
    {
        return $value ? web_resource_url($value) : '';
    }
}
