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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('full_name')->nullable()->comment('全名');
            $table->string('first_name')->nullable()->comment('名字');
            $table->string('last_name')->nullable()->comment('姓氏');
			$table->tinyInteger('role')->default(0)->comment('状态:0-学生/1-老师');
			$table->tinyInteger('status')->default(0)->comment('状态:0-正常/1-禁用');
            $table->string('remember_token')->nullable();
            $table->softDeletes()->index('idx_deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
