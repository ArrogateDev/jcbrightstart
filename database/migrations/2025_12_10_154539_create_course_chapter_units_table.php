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
        Schema::create('course_chapter_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('chapter_id');
            $table->string('title')->nullable()->comment('Title');
            $table->string('video_url')->nullable()->comment('Video Url');
            $table->string('file')->nullable()->comment('File');
            $table->tinyInteger('type')->default(0)->comment('Type');
            $table->unsignedBigInteger('quiz_id')->default(0)->comment('Quiz Id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_chapter_units');
    }
};
