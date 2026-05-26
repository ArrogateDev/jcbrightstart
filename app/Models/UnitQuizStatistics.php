<?php

namespace App\Models;

use App\Models\Course\CourseChapter;
use App\Models\Course\CourseChapterUnit;

class UnitQuizStatistics extends Base
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
     * 更新或创建统计信息
     *
     * @param int $userId
     * @param int $courseId
     * @param int $chapterId
     * @param int $unitId
     * @param int $quizId
     * @param bool $isCorrect
     * @return UnitQuizStatistics
     */
    public static function updateStatistics($userId, $courseId, $chapterId, $unitId, $quizId, $isCorrect)
    {
        // 获取测验信息，确定题目总数
        $quiz = Quiz::find($quizId);
        $totalQuestions = 0;
        if ($quiz && is_array($quiz->questions)) {
            $totalQuestions = count($quiz->questions);
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
                'total_questions' => $totalQuestions,
                'answered' => 0,
                'correct' => 0,
                'incorrect' => 0,
                'unanswered' => $totalQuestions,
                'correct_rate' => 0,
                'first_answered_at' => now(),
            ]
        );

        // 如果题目总数发生变化，更新
        if ($statistics->total_questions != $totalQuestions) {
            $statistics->total_questions = $totalQuestions;
        }

        // 获取该用户在该单元的所有答题记录
        $answerRecords = QuizAnswerRecord::query()
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('chapter_id', $chapterId)
            ->where('unit_id', $unitId)
            ->where('quiz_id', $quizId)
            ->get();

        // 按题目索引分组，取最新的答题记录
        $latestAnswers = $answerRecords->groupBy('question_index')->map(function ($records) {
            return $records->sortByDesc('answered_at')->first();
        });

        // 统计已答题数（去重）
        $answeredCount = $latestAnswers->count();

        // 统计正确数和错误数
        $correctCount = $latestAnswers->where('is_correct', true)->count();
        $incorrectCount = $latestAnswers->where('is_correct', false)->count();

        // 未答题数
        $unansweredCount = max(0, $totalQuestions - $answeredCount);

        // 正确率（百分比）
        $correctRate = $answeredCount > 0
            ? round(($correctCount / $answeredCount) * 100, 2)
            : 0;

        // 更新统计信息
        $statistics->answered = $answeredCount;
        $statistics->correct = $correctCount;
        $statistics->incorrect = $incorrectCount;
        $statistics->unanswered = $unansweredCount;
        $statistics->correct_rate = $correctRate;
        $statistics->last_answered_at = now();

        // 如果所有题目都已答完，设置完成时间
        if ($answeredCount >= $totalQuestions && $totalQuestions > 0) {
            if (!$statistics->completed_at) {
                $statistics->completed_at = now();
            }
        }

        $statistics->save();

        return $statistics;
    }
}
