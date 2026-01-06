<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_play_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('User ID');
            $table->unsignedBigInteger('course_id')->comment('Course ID');
            $table->unsignedBigInteger('chapter_id')->comment('Chapter ID');
            $table->unsignedBigInteger('unit_id')->comment('Unit ID');
            $table->integer('play_position')->default(0)->comment('Play Position (seconds)');
            $table->timestamp('start_time')->nullable()->comment('Play Start Time');
            $table->timestamp('end_time')->nullable()->comment('Play End Time');
            $table->integer('duration')->default(0)->comment('Play Duration (seconds)');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'course_id'], 'idx_uc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_play_records');
    }
};
