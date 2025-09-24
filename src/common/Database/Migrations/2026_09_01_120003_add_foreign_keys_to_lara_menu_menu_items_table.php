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
        Schema::table('lara_menu_menu_items', function (Blueprint $table) {
            $table->foreign(['menu_id'], 'lara_menu_menu_items_ibfk_1')->references(['id'])->on('lara_menu_menus')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['entity_id'], 'lara_menu_menu_items_ibfk_2')->references(['id'])->on('lara_resource_entities')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['entity_view_id'], 'lara_menu_menu_items_ibfk_3')->references(['id'])->on('lara_resource_entity_views')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lara_menu_menu_items', function (Blueprint $table) {
            $table->dropForeign('lara_menu_menu_items_ibfk_1');
            $table->dropForeign('lara_menu_menu_items_ibfk_2');
            $table->dropForeign('lara_menu_menu_items_ibfk_3');
        });
    }
};
