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
        Schema::create('lara_form_classicforms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('mydate')->nullable();
            $table->integer('myradio')->default(0);
            $table->text('myselect')->nullable();
            $table->text('mycomment')->nullable();
            $table->boolean('myboolean')->default(false);
            $table->string('myemail')->nullable();
            $table->string('myname')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_form_classicforms');
    }
};
