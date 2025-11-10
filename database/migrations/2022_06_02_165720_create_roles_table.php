<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('角色名称');
            $table->smallInteger('level')->default(1)->comment('级别');
            $table->unsignedBigInteger('pid')->default(0)->comment('上级');
			$table->tinyInteger('status')->default(0)->comment('状态:0-正常/1-禁用');
            $table->softDeletes()->index('idx_deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
