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
        Schema::create('lara_sys_languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->text('name')->nullable();
            $table->boolean('default')->default(false);
            $table->boolean('backend')->default(false);
            $table->boolean('backend_default')->default(false);
            $table->boolean('publish')->default(false);
            $table->unsignedInteger('position')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_sys_languages');
    }
};
