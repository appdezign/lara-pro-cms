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
        Schema::table('lara_auth_role_has_permissions', function (Blueprint $table) {
            $table->foreign(['permission_id'], 'role_has_permissions_permission_id_foreign')->references(['id'])->on('lara_auth_permissions')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['role_id'], 'role_has_permissions_role_id_foreign')->references(['id'])->on('lara_auth_roles')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lara_auth_role_has_permissions', function (Blueprint $table) {
            $table->dropForeign('role_has_permissions_permission_id_foreign');
            $table->dropForeign('role_has_permissions_role_id_foreign');
        });
    }
};
