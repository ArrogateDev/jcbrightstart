<?php

namespace App\Models\Course;

use App\Models\Base;

class CourseChapter extends Base
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units()
    {
        return $this->hasMany(CourseChapterUnit::class, 'chapter_id', 'id');
    }
}
