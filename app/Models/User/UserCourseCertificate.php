<?php

namespace App\Models\User;

use App\Models\Base;

class UserCourseCertificate extends Base
{
    /**
     * 未生成
     */
    const STATUS_NOT_GENERATED = 0;

    /**
     * 已生成
     */
    const STATUS_GENERATED = 1;

    /**
     * @param $value
     * @return string
     */
    public function getFileUrlAttribute()
    {
        $file = $this->file;
        return $file ? web_resource_url($file) : '';
    }
}
