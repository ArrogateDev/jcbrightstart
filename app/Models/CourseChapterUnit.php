<?php

namespace App\Models;

class CourseChapterUnit extends Base
{
    protected $appends = [
        'video_id',
        'file_url'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }

    /**
     * @return string
     */
    public function getVideoIdAttribute()
    {
        $url = $this->video_url;
        if (!$url) return '';

        $video_id = '';
        // 如果是 youtu.be 短链接
        if (str_contains($url, 'youtu.be')) {
            $path = parse_url($url, PHP_URL_PATH);
            $video_id = $path ? ltrim($path, '/') : '';
        }

        // 如果是标准的 youtube.com 链接
        if (str_contains($url, 'youtube.com') && ($query_string = parse_url($url, PHP_URL_QUERY))) {
            parse_str($query_string, $params);
            $video_id = $params['v'] ?? '';
        }

        // 可能是嵌入链接 /embed/VIDEO_ID
        $path = parse_url($url, PHP_URL_PATH);
        if (preg_match('/^\/embed\/([a-zA-Z0-9_-]{11})/', $path, $matches)) {
            $video_id = $matches[1];
        }

        return $video_id;
    }

    /**
     * @return string
     */
    public function getFileUrlAttribute()
    {
        return $this->file ? web_resource_url($this->file) : '';
    }
}
