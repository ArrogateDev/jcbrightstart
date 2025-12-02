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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('Title');
            $table->string('thumbnail')->nullable()->comment('Thumbnail');
            $table->string('video_url')->nullable()->comment('Video Url');
            $table->unsignedBigInteger('category_id')->default(0)->comment('Category');
            $table->tinyInteger('level')->default(0)->comment('Level');
            $table->tinyInteger('language')->default(0)->comment('Language');
            $table->text('short')->nullable()->comment('Short');
            $table->text('description')->nullable()->comment('Description');
            $table->json('acquire')->nullable()->comment('Acquire');
            $table->json('requirements')->nullable()->comment('Requirements');
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
        Schema::dropIfExists('courses');
    }
};
