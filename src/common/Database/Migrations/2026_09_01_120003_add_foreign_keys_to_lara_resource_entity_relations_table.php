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
        Schema::table('lara_resource_entity_relations', function (Blueprint $table) {
            $table->foreign(['entity_id'], 'lara_resource_entity_relations_ibfk_1')->references(['id'])->on('lara_resource_entities')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['related_entity_id'], 'lara_resource_entity_relations_ibfk_2')->references(['id'])->on('lara_resource_entities')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lara_resource_entity_relations', function (Blueprint $table) {
            $table->dropForeign('lara_resource_entity_relations_ibfk_1');
            $table->dropForeign('lara_resource_entity_relations_ibfk_2');
        });
    }
};
