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
        Schema::create('user_course_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('User ID');
            $table->unsignedBigInteger('course_id')->comment('Course ID');
            $table->unsignedBigInteger('certificate_id')->comment('Certificate ID');
            $table->string('certificate_name')->nullable()->comment('Certificate Name');
            $table->string('full_name')->nullable()->comment('User Name');
            $table->string('file')->nullable()->comment('File');
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
        Schema::dropIfExists('user_course_certificates');
    }
};
