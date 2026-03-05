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
			$table->string('avatar')->nullable()->comment('头像');
            $table->string('email')->nullable()->unique();
            $table->string('apple_id')->nullable()->unique()->comment('苹果用户唯一标识符');
            $table->string('password')->nullable();
            $table->string('full_name')->nullable()->comment('全名');
            $table->string('first_name')->nullable()->comment('名字');
            $table->string('last_name')->nullable()->comment('姓氏');
			$table->tinyInteger('gender')->default(2)->comment('性别:0-女/1-男/2-沒有提供');
			$table->tinyInteger('age')->default(0)->comment('年龄');
			$table->tinyInteger('role')->default(0)->comment('状态:0-学生/1-老师');
			$table->tinyInteger('is_private_email')->default(1)->comment('私有邮箱:0-是/1-否');
			$table->tinyInteger('is_first_login')->default(0)->comment('第一次登录:0-是/1-否');
			$table->tinyInteger('status')->default(0)->comment('状态:0-正常/1-禁用');
            $table->string('remember_token')->nullable();
            $table->softDeletes()->index('idx_deleted_at');

            $table->index(['email', 'deleted_at'], 'unique_email');
            $table->index(['apple_id', 'deleted_at'], 'unique_apple_id');

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
