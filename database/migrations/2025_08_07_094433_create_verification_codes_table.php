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
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id();
			$table->char('account', 30)->index()->comment('账号');
			$table->char('code', 20)->comment('验证码');
			$table->char('scene', 30)->comment('场景');
			$table->string('message')->nullable()->comment('第三方返回的信息');
			$table->string('ip', 50)->default('')->comment('IP');
			$table->unsignedInteger('status')->comment('状态: 0-发送失败/1-发送成功');
			$table->unsignedTinyInteger('used')->comment('使用状态:0-未使用/1-已使用');
			$table->timestamp('used_at')->nullable()->comment('使用时间');
            $table->softDeletes()->index('idx_deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_codes');
    }
};
