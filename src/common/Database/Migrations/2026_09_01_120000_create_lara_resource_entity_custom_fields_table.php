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
        Schema::create('lara_resource_entity_custom_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('entity_id')->index('entity_id');
            $table->string('title')->nullable();
            $table->string('field_hook')->nullable();
            $table->string('field_type')->nullable();
            $table->string('field_name')->nullable();
            $table->string('field_name_temp')->nullable();
            $table->longText('field_options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_filter')->default(false);
            $table->boolean('show_in_list')->default(false);
            $table->boolean('conditional')->default(false);
            $table->string('rule_state')->nullable();
            $table->string('rule_field')->nullable();
            $table->string('rule_operator')->nullable();
            $table->string('rule_value')->nullable();
            $table->integer('sort_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_resource_entity_custom_fields');
    }
};
