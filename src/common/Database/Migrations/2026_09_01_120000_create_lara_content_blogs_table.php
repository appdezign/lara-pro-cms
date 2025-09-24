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
        Schema::create('lara_content_blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->string('language')->nullable();
            $table->unsignedBigInteger('language_parent')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('slug_lock')->nullable();
            $table->text('lead')->nullable();
            $table->text('body')->nullable();
            $table->text('body2')->nullable();
            $table->boolean('sticky')->default(false);
            $table->string('source')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('publish')->default(false);
            $table->timestamp('publish_from')->nullable();
            $table->boolean('publish_expire')->default(false);
            $table->timestamp('publish_to')->nullable();
            $table->boolean('publish_hide')->default(false);
            $table->string('cgroup')->nullable();
            $table->integer('position')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_content_blogs');
    }
};
