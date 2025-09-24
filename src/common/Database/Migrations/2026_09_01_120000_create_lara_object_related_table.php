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
        Schema::create('lara_object_related', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('entity_type')->nullable();
            $table->unsignedBigInteger('entity_id');
            $table->json('related_page_objects')->nullable();
            $table->json('related_entity_objects')->nullable();
            $table->json('related_entities')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_object_related');
    }
};
