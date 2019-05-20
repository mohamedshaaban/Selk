<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomePageGiftBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_page_gift_boxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('small_image_ar');
            $table->string('large_image_ar');
            $table->string('small_image_en');
            $table->string('large_image_en');
            $table->integer('sort_order')->default(1);
            $table->integer('status')->default(1);
            $table->text('url');
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
        Schema::dropIfExists('home_page_gift_boxes');
    }
}
