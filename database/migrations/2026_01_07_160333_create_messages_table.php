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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(0)->comment('User ID');
            $table->string('email')->comment('Email');
            $table->string('name')->comment('Name');
            $table->text('message')->comment('Message');
            $table->string('ip')->comment('ip');
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
        Schema::dropIfExists('messages');
    }
};
