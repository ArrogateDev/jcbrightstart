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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('Title');
            $table->string('thumbnail')->nullable()->comment('Thumbnail');
            $table->tinyInteger('thumbnail_show')->default(1)->comment('Thumbnail Show');
            $table->unsignedBigInteger('category_top_id')->default(0)->comment('Category');
            $table->unsignedBigInteger('category_id')->default(0)->comment('Category');
            $table->text('short')->nullable()->comment('Short');
            $table->string('pdf')->nullable()->comment('Pdf');
            $table->text('description')->nullable()->comment('Description');
            $table->smallInteger('sort')->default(0)->comment('排序');
            $table->unsignedBigInteger('view')->default(0)->comment('View');
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
        Schema::dropIfExists('resources');
    }
};
