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
            $table->string('mediable_type');
            $table->unsignedBigInteger('mediable_id');
            $table->unsignedBigInteger('media_id')->index('media_items_media_id_foreign');
            $table->integer('order');
            $table->string('type');
            $table->timestamps();

            $table->index(['mediable_type', 'mediable_id'], 'media_items_mediable_type_mediable_id_index');
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
