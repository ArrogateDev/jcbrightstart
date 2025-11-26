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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('证书模板名称');
            $table->string('path')->comment('证书模板图片路径');
            $table->json('name_config')->nullable()->comment('姓名配置：{left, top, fontSize, fill, textAlign}');
            $table->json('date_config')->nullable()->comment('日期配置：{left, top, fontSize, fill, textAlign}');
            $table->integer('width')->default(800)->comment('画布宽度');
            $table->integer('height')->default(600)->comment('画布高度');
            $table->tinyInteger('status')->default(0)->comment('状态：0-正常/1-禁用');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
