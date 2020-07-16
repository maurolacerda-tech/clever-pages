<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('menu_id')->unsigned()->nullable()->default(null);
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');


            $table->string('name');
            $table->string('slug')->unique();            
            $table->longText('summary');
            $table->longText('body');
            $table->string('image')->nullable();
            $table->text('more_images')->nullable();
            
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
