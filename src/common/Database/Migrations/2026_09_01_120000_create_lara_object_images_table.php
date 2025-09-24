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
        Schema::create('lara_object_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('entity_type')->nullable();
            $table->unsignedBigInteger('entity_id')->index('entity_id');
            $table->json('featured')->nullable();
            $table->json('thumb')->nullable();
            $table->json('hero')->nullable();
            $table->json('icon')->nullable();
            $table->json('gallery')->nullable();
            $table->json('gallery_upload')->nullable();
            $table->integer('image_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_object_images');
    }
};
