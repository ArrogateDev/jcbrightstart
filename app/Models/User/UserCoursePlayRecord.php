<?php

namespace App\Models\User;

use App\Models\Base;
use App\Models\Course\Course;
use App\Models\Course\CourseChapter;
use App\Models\Course\CourseChapterUnit;

class UserCoursePlayRecord extends Base
{

    /**
     * 未完成
     */
    public const UNFINISHED = 0;

    /**
     * 播放完成
     */
    public const PLAY_COMPLETED = 1;

    /**
     * 测验完成
     */
    public const QUIZ_COMPLETED = 2;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chapter()
    {
        return $this->belongsTo(CourseChapter::class, 'chapter_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(CourseChapterUnit::class, 'unit_id', 'id');
    }
}
