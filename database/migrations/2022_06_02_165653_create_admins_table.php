<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
			$table->string('name')->comment('姓名');
			$table->string('avatar')->nullable()->comment('头像');
			$table->string('account')->nullable()->comment('账号');
			$table->string('password')->comment('密码');
			$table->tinyInteger('status')->default(0)->comment('状态:0-正常/1-禁用');
            $table->softDeletes()->index('idx_deleted_at');
            $table->timestamps();

            $table->unique(['account'], 'unique_a');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
