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
        Schema::create('seo_not_founds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path')->unique();
            $table->unsignedBigInteger('hits')->default(1);
            $table->string('last_referer')->nullable();
            $table->boolean('ignored')->default(false);
            $table->timestamp('last_hit_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_not_founds');
    }
};
