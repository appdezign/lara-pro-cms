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
        Schema::create('lara_resource_entities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('resource_slug')->nullable();
            $table->string('label_single')->nullable();
            $table->string('resource')->nullable();
            $table->string('policy')->nullable();
            $table->string('model_class')->nullable();
            $table->string('controller')->nullable();
            $table->string('nav_group')->nullable();
            $table->boolean('has_front_auth')->default(false);
            $table->timestamps();
            $table->string('cgroup')->nullable();
            $table->unsignedInteger('position')->nullable()->index('lara_sys_settings_position_index');
            $table->boolean('col_has_lead')->default(false);
            $table->boolean('col_has_body')->default(false);
            $table->integer('col_extra_body_fields')->default(0);
            $table->boolean('col_has_status')->default(false);
            $table->boolean('col_has_expiration')->default(false);
            $table->boolean('col_has_hideinlist')->default(false);
            $table->boolean('sort_is_sortable')->default(false);
            $table->string('sort_primary_field')->nullable();
            $table->string('sort_primary_order')->nullable();
            $table->string('sort_secondary_field')->nullable();
            $table->string('sort_secondary_order')->nullable();
            $table->boolean('show_search')->default(false);
            $table->boolean('show_batch')->default(false);
            $table->boolean('show_status')->default(false);
            $table->boolean('show_seo')->default(false);
            $table->boolean('show_opengraph')->default(false);
            $table->boolean('show_author')->default(false);
            $table->boolean('show_sync')->default(false);
            $table->boolean('show_rich_lead')->default(false);
            $table->boolean('show_rich_body')->default(false);
            $table->boolean('show_view_action')->default(false);
            $table->boolean('show_edit_action')->default(false);
            $table->boolean('show_delete_action')->default(false);
            $table->boolean('show_restore_action')->default(false);
            $table->boolean('filter_by_trashed')->default(false);
            $table->boolean('filter_by_group')->default(false);
            $table->boolean('filter_by_status')->default(false);
            $table->boolean('filter_by_category')->default(false);
            $table->boolean('filter_by_tag')->default(false);
            $table->boolean('filter_by_author')->default(false);
            $table->boolean('filter_is_open')->default(false);
            $table->boolean('media_has_featured')->default(false);
            $table->boolean('media_has_thumb')->default(false);
            $table->boolean('media_has_hero')->default(false);
            $table->boolean('media_has_icon')->default(false);
            $table->boolean('media_has_gallery')->default(false);
            $table->boolean('media_has_gallery_pro')->default(false);
            $table->boolean('media_has_videos')->default(false);
            $table->boolean('media_has_videofiles')->default(false);
            $table->boolean('media_has_files')->default(false);
            $table->integer('media_max_gallery')->default(0);
            $table->integer('media_max_videos')->default(0);
            $table->integer('media_max_videofiles')->default(0);
            $table->integer('media_max_files')->default(0);
            $table->boolean('objrel_has_terms')->default(false);
            $table->boolean('objrel_has_groups')->default(false);
            $table->json('objrel_group_values')->nullable();
            $table->boolean('objrel_has_related')->default(false);
            $table->boolean('objrel_is_relatable')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_resource_entities');
    }
};
