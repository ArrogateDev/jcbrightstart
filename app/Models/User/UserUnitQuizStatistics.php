<?php

namespace App\Models\User;

use App\Models\Base;
use App\Models\Course\Course;
use App\Models\Course\CourseChapter;
use App\Models\Course\CourseChapterUnit;
use App\Models\Quiz;

class UserUnitQuizStatistics extends Base
{
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
    public function getTitleAttribute()
    {
        $course_title = $this->course->title ?? '';
        $chapter_title = $this->chapter->title ?? '';
        $unit_title = $this->unit->title ?? '';
        $quiz_title = $this->quiz->title ?? '';

        return $course_title . '/' . $chapter_title . '/' . $unit_title . '/' . $quiz_title;
    }

    /**
     * 更新或创建统计信息
     *
     * @param int $userId
     * @param int $courseId
     * @param int $chapterId
     * @param int $unitId
     * @param int $quizId
     * @param bool $isCorrect
     * @return UserUnitQuizStatistics
     */
    public static function updateStatistics($userId, $courseId, $chapterId, $unitId, $quizId, $isCorrect)
    {
        // 获取测验信息，确定题目总数
        $quiz = Quiz::find($quizId);
        $total_questions = 0;
        if ($quiz && is_array($quiz->questions)) {
            $total_questions = count($quiz->questions);
        }

        // 获取或创建统计记录
        $statistics = static::firstOrCreate(
            [
                'user_id' => $userId,
                'course_id' => $courseId,
                'chapter_id' => $chapterId,
                'unit_id' => $unitId,
                'quiz_id' => $quizId,
            ],
            [
                'total_questions' => $total_questions,
                'answered' => 0,
                'correct' => 0,
                'incorrect' => 0,
                'unanswered' => $total_questions,
                'correct_rate' => 0,
                'first_answered_at' => now(),
            ]
        );

        // 如果题目总数发生变化，更新
        if ($statistics->total_questions != $total_questions) {
            $statistics->total_questions = $total_questions;
        }

        // 获取该用户在该单元的所有答题记录
        $answer_records = UserQuizAnswerRecord::query()
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('chapter_id', $chapterId)
            ->where('unit_id', $unitId)
            ->where('quiz_id', $quizId)
            ->get();

        // 按题目索引分组，取最新的答题记录
        $latest_answers = $answer_records->groupBy('question_index')->map(function ($records) {
            return $records->sortByDesc('answered_at')->first();
        });

        // 统计已答题数（去重）
        $answered_count = $latest_answers->count();

        // 统计正确数和错误数
        $correct_count = $latest_answers->where('is_correct', true)->count();
        $incorrectCount = $latest_answers->where('is_correct', false)->count();

        // 未答题数
        $unanswered_count = max(0, $total_questions - $answered_count);

        // 正确率（百分比）
        $correctRate = $answered_count > 0
            ? round(($correct_count / $answered_count) * 100, 2)
            : 0;

        // 更新统计信息
        $statistics->answered = $answered_count;
        $statistics->correct = $correct_count;
        $statistics->incorrect = $incorrectCount;
        $statistics->unanswered = $unanswered_count;
        $statistics->correct_rate = $correctRate;
        $statistics->last_answered_at = now();

        // 如果所有题目都已答完，设置完成时间
        if ($answered_count >= $total_questions && $total_questions > 0) {
            if (!$statistics->completed_at) {
                $statistics->completed_at = now();
            }
        }

        $statistics->save();

        return $statistics;
    }
}
