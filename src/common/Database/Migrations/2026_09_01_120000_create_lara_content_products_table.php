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
        Schema::create('lara_content_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('lara_content_products_user_id_foreign');
            $table->string('language')->nullable();
            $table->unsignedBigInteger('language_parent')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('slug_lock')->default(false);
            $table->text('lead')->nullable();
            $table->text('body')->nullable();
            $table->string('mycolor')->nullable();
            $table->json('myradio')->nullable();
            $table->boolean('mycheckbox')->default(false);
            $table->json('mycheckboxlist')->nullable();
            $table->json('mymultitogglebuttons')->nullable();
            $table->text('mytogglebuttons')->nullable();
            $table->boolean('mytoggle')->default(false);
            $table->json('mytagsinput')->nullable();
            $table->json('mymultiselect')->nullable();
            $table->text('myselect_2')->nullable();
            $table->timestamp('mydatetime')->nullable();
            $table->time('mytime')->nullable();
            $table->date('mydate')->nullable();
            $table->decimal('mydecimal', 16, 4)->default(0);
            $table->text('mytextarea')->nullable();
            $table->integer('mynumber')->default(0);
            $table->text('mytext')->nullable();
            $table->string('myemail')->nullable();
            $table->string('mystring')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('publish')->default(false);
            $table->timestamp('publish_from')->nullable();
            $table->boolean('publish_expire')->default(false);
            $table->timestamp('publish_to')->nullable();
            $table->boolean('publish_hide')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->string('cgroup')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lara_content_products');
    }
};
