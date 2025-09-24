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
        Schema::create('lara_object_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('language')->nullable();
            $table->unsignedBigInteger('language_parent')->nullable();
            $table->unsignedBigInteger('taxonomy_id')->index('lara_object_tags_taxonomy_id_foreign');
            $table->string('resource_slug')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('slug_lock')->default(false);
            $table->text('lead')->nullable();
            $table->text('body')->nullable();
            $table->string('route')->nullable();
            $table->boolean('locked_by_admin')->default(false);
            $table->timestamps();
            $table->boolean('publish')->default(false);
            $table->unsignedInteger('parent_id')->nullable()->index();
            $table->unsignedInteger('lft')->nullable()->index();
            $table->unsignedInteger('rgt')->nullable()->index();
            $table->unsignedInteger('depth')->default(0)->index();
            $table->unsignedInteger('position')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_object_tags');
    }
};
