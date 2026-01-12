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
        Schema::create('user_unit_quiz_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('User ID');
            $table->unsignedBigInteger('course_id')->comment('Course ID');
            $table->unsignedBigInteger('chapter_id')->comment('Chapter ID');
            $table->unsignedBigInteger('unit_id')->comment('Unit ID');
            $table->unsignedBigInteger('quiz_id')->comment('Quiz ID');
            $table->integer('total_questions')->default(0)->comment('Total Questions');
            $table->integer('answered')->default(0)->comment('Answered Count');
            $table->integer('correct')->default(0)->comment('Correct Count');
            $table->integer('incorrect')->default(0)->comment('Incorrect Count');
            $table->integer('unanswered')->default(0)->comment('Unanswered Count');
            $table->decimal('correct_rate', 5, 2)->default(0)->comment('Correct Rate (%)');
            $table->timestamp('first_answered_at')->nullable()->comment('First Answered At');
            $table->timestamp('last_answered_at')->nullable()->comment('Last Answered At');
            $table->timestamp('completed_at')->nullable()->comment('Completed At');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['user_id', 'course_id', 'unit_id', 'quiz_id'], 'idx_user_course_unit_quiz');
            $table->index(['user_id', 'course_id'], 'idx_user_course');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_quiz_statistics');
    }
};
