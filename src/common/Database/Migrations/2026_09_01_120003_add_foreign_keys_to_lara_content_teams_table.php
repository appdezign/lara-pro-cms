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
        Schema::table('lara_content_teams', function (Blueprint $table) {
            $table->foreign(['location_id'], 'lara_content_teams_ibfk_1')->references(['id'])->on('lara_content_locations')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('lara_auth_users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lara_content_teams', function (Blueprint $table) {
            $table->dropForeign('lara_content_teams_ibfk_1');
            $table->dropForeign('lara_content_teams_user_id_foreign');
        });
    }
};
