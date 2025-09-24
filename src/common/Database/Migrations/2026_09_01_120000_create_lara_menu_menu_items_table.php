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
        Schema::create('lara_menu_menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('language')->nullable();
            $table->unsignedBigInteger('language_parent')->nullable();
            $table->unsignedBigInteger('menu_id')->index('menu_id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->boolean('slug_lock')->default(false);
            $table->string('type');
            $table->boolean('is_home')->default(false);
            $table->string('route')->nullable();
            $table->string('routename')->nullable();
            $table->boolean('route_has_auth')->default(false);
            $table->unsignedBigInteger('entity_id')->nullable()->index('entity_id');
            $table->unsignedBigInteger('entity_view_id')->nullable()->index('entity_view_id');
            $table->unsignedBigInteger('object_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->string('url')->nullable();
            $table->boolean('locked_by_admin')->default(false);
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->boolean('publish')->default(false);
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->default(0);
            $table->unsignedInteger('position')->default(0);

            $table->index(['lft', 'rgt', 'parent_id'], 'lara_menu_menu_items__lft__rgt_parent_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_menu_menu_items');
    }
};
