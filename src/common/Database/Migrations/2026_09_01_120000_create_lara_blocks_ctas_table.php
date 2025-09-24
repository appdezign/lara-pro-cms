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
        Schema::create('lara_blocks_ctas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('lara_blocks_ctas_user_id_foreign');
            $table->string('language')->nullable();
            $table->unsignedBigInteger('language_parent')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('slug_lock')->default(false);
            $table->text('lead')->nullable();
            $table->text('body')->nullable();
            $table->text('overlaytransp')->nullable();
            $table->text('overlaycolor')->nullable();
            $table->text('type')->nullable();
            $table->text('hook')->nullable();
            $table->string('linkurl')->nullable();
            $table->string('linktext')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('publish')->default(false);
            $table->timestamp('publish_from')->nullable();
            $table->boolean('publish_expire')->default(false);
            $table->timestamp('publish_to')->nullable();
            $table->unsignedInteger('position')->nullable();
            $table->string('cgroup')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_blocks_ctas');
    }
};
