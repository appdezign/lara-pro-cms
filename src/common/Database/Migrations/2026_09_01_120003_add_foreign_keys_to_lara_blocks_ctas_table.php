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
        Schema::table('lara_blocks_ctas', function (Blueprint $table) {
            $table->foreign(['locked_by'])->references(['id'])->on('lara_auth_users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('lara_auth_users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lara_blocks_ctas', function (Blueprint $table) {
            $table->dropForeign('lara_blocks_ctas_locked_by_foreign');
            $table->dropForeign('lara_blocks_ctas_user_id_foreign');
        });
    }
};
