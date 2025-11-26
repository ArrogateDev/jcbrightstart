<?php

namespace App\Models;

class Certificate extends Base
{
    protected $casts = [
        'name_config' => 'array',
        'date_config' => 'array',
    ];

    /**
     * @param $value
     * @return string
     */
    public function getPathAttribute($value)
    {
        return $value ? web_resource_url($value) : '';
    }
}
