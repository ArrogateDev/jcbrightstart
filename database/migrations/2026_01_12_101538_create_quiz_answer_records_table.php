<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_answer_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('User ID');
            $table->unsignedBigInteger('course_id')->comment('Course ID');
            $table->unsignedBigInteger('chapter_id')->comment('Chapter ID');
            $table->unsignedBigInteger('unit_id')->comment('Unit ID');
            $table->unsignedBigInteger('quiz_id')->comment('Quiz ID');
            $table->integer('question_index')->comment('Question Index');
            $table->integer('user_answer')->nullable()->comment('User Answer Index');
            $table->integer('correct_answer')->comment('Correct Answer Index');
            $table->boolean('is_correct')->default(false)->comment('Is Correct');
            $table->timestamp('answered_at')->nullable()->comment('Answered At');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'course_id', 'unit_id', 'quiz_id'], 'idx_user_course_unit_quiz');
            $table->index(['user_id', 'course_id', 'unit_id', 'quiz_id', 'question_index'], 'idx_user_course_unit_quiz_question');
            $table->index('answered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_answer_records');
    }
};
