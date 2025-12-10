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
        return $value ? web_resource_url($value) : web_resource_url('assets/img/fill.png');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters()
    {
        return $this->hasMany(CourseChapter::class, 'course_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'id','certificate_id');
    }
}
