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
        Schema::create('lara_resource_entity_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('entity_id')->index('lara_ent_entity_relations_entity_id_foreign');
            $table->string('type')->nullable();
            $table->unsignedBigInteger('related_entity_id')->index('lara_ent_entity_relations_related_entity_id_foreign');
            $table->string('foreign_key')->nullable();
            $table->boolean('is_filter')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_resource_entity_relations');
    }
};
