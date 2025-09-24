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
        Schema::create('lara_object_layout', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('entity_type')->nullable();
            $table->unsignedBigInteger('entity_id')->index('entity_id');
            $table->string('header')->nullable();
            $table->string('hero')->nullable();
            $table->string('pagetitle')->nullable();
            $table->string('content')->nullable();
            $table->string('share')->nullable();
            $table->string('cta')->nullable();
            $table->string('footer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_object_layout');
    }
};
