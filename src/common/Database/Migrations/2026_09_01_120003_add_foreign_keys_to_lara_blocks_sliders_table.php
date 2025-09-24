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
        Schema::table('lara_blocks_sliders', function (Blueprint $table) {
            $table->foreign(['user_id'], 'lara_content_sliders_user_id_foreign')->references(['id'])->on('lara_auth_users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lara_blocks_sliders', function (Blueprint $table) {
            $table->dropForeign('lara_content_sliders_user_id_foreign');
        });
    }
};
