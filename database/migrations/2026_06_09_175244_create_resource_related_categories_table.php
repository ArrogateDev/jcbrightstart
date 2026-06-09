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
        Schema::create('resource_related_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('resource_id');
            $table->unsignedBigInteger('category_id');
            $table->unique(['resource_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_related_categories');
    }
};
