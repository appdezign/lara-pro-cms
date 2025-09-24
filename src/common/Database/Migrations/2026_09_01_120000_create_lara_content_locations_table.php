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
        Schema::create('lara_content_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('lara_content_locations_user_id_foreign');
            $table->string('language')->nullable();
            $table->unsignedBigInteger('language_parent')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('slug_lock')->default(false);
            $table->text('lead')->nullable();
            $table->text('body')->nullable();
            $table->decimal('geo_longitude', 11, 8)->nullable();
            $table->decimal('geo_latitude', 10, 8)->nullable();
            $table->string('geo_full_address')->nullable();
            $table->decimal('longitude', 11, 8)->default(0);
            $table->decimal('latitude', 10, 8)->default(0);
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('pcode')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('publish')->default(false);
            $table->timestamp('publish_from')->nullable();
            $table->boolean('publish_expire')->default(false);
            $table->timestamp('publish_to')->nullable();
            $table->boolean('publish_hide')->default(false);
            $table->unsignedInteger('position')->nullable();
            $table->string('cgroup')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_content_locations');
    }
};
