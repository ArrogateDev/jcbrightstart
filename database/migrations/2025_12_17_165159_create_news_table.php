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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('Title');
            $table->string('thumbnail')->nullable()->comment('Thumbnail');
            $table->tinyInteger('thumbnail_show')->default(1)->comment('Thumbnail Show');
            $table->unsignedBigInteger('category_id')->default(0)->comment('Category');
            $table->text('short')->nullable()->comment('Short');
            $table->text('description')->nullable()->comment('Description');
            $table->date('start_date')->nullable()->comment('Start Date');
            $table->date('end_date')->nullable()->comment('End Date');
            $table->time('start_time')->nullable()->comment('Start Time');
            $table->time('end_time')->nullable()->comment('End Time');
            $table->date('end_date')->nullable()->comment('End Date');
            $table->date('release_date')->nullable()->comment('Release Date');
            $table->smallInteger('sort')->default(0)->comment('排序');
            $table->tinyInteger('status')->default(0)->comment('Status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
