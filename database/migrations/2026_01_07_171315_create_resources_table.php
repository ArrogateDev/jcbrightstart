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
            $table->unsignedBigInteger('category_id')->default(0)->comment('Category');
            $table->text('short')->nullable()->comment('Short');
            $table->string('pdf')->nullable()->comment('Pdf');
            $table->text('description')->nullable()->comment('Description');
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
