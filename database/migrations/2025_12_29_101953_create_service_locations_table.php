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
        Schema::create('service_locations', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('Type');
            $table->string('age')->comment('Age');
            $table->string('district')->comment('District');
            $table->string('capacity')->comment('Capacity');
            $table->string('organization')->comment('Organization');
            $table->string('address')->comment('Address');
            $table->string('phone')->comment('Phone');
            $table->string('email')->comment('Email');
            $table->string('webpage')->comment('Webpage');
            $table->string('service_hour')->comment('Service Hour');
            $table->decimal('longitude', 12, 8)->comment('Longitude');
            $table->decimal('latitude', 12, 8)->comment('Latitude');
            $table->string('point_color', 10)->nullable()->comment('Map Point Color');
            $table->smallInteger('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('service_locations');
    }
};
