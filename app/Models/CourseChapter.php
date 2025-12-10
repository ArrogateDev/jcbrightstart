<?php

namespace App\Models;

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
