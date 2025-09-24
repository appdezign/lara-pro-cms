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
        Schema::table('lara_content_blogs', function (Blueprint $table) {
            $table->foreign(['user_id'], 'lara_content_blogs_ibfk_1')->references(['id'])->on('lara_auth_users')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lara_content_blogs', function (Blueprint $table) {
            $table->dropForeign('lara_content_blogs_ibfk_1');
        });
    }
};
