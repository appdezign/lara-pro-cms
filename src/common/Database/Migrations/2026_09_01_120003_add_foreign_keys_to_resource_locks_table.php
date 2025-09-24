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
        Schema::table('resource_locks', function (Blueprint $table) {
            $table->foreign(['user_id'])->references(['id'])->on('lara_auth_users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resource_locks', function (Blueprint $table) {
            $table->dropForeign('resource_locks_user_id_foreign');
        });
    }
};
