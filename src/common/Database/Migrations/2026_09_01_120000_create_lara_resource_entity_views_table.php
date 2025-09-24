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
        Schema::create('lara_resource_entity_views', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('entity_id')->index('entity_id');
            $table->string('title')->nullable();
            $table->string('method')->nullable();
            $table->string('filename')->nullable();
            $table->string('template')->nullable();
            $table->integer('template_extra_fields')->default(0);
            $table->boolean('is_single')->default(false);
            $table->string('list_type')->nullable();
            $table->boolean('image_required')->default(false);
            $table->string('showtags')->nullable();
            $table->integer('paginate')->nullable();
            $table->boolean('infinite')->default(false);
            $table->boolean('prevnext')->default(false);
            $table->boolean('publish')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_resource_entity_views');
    }
};
