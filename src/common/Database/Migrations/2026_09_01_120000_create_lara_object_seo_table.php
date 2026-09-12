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
        Schema::create('lara_object_seo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->string('title')->nullable();
            $table->string('description', 500)->nullable();
            $table->string('focus_keyword')->nullable();
            $table->json('additional_keywords')->nullable();
            $table->boolean('is_cornerstone')->default(false);
            $table->string('locale', 12)->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('noindex')->default(false);
            $table->boolean('nofollow')->default(false);
            $table->unsignedTinyInteger('score')->nullable();
            $table->timestamps();

            $table->index(['model_type', 'model_id'], 'lara_object_seo_metas_model_type_model_id_index');
            $table->unique(['model_type', 'model_id'], 'lara_object_seo_metas_model_type_model_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_object_seo');
    }
};
