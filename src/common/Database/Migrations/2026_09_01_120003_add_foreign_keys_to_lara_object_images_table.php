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
        Schema::table('lara_object_images', function (Blueprint $table) {
            $table->foreign(['media_id'], 'lara_object_images_ibfk_1')->references(['id'])->on('curator')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lara_object_images', function (Blueprint $table) {
            $table->dropForeign('lara_object_images_ibfk_1');
        });
    }
};
