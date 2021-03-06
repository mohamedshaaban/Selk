<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('slug_name')->unique();
            $table->string('sku')->unique();
            $table->string('short_description_en')->nullable();
            $table->string('short_description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('delivery_and_return_en')->nullable();
            $table->text('delivery_and_return_ar')->nullable();
            $table->float('price');
            $table->integer('quantity');
            $table->integer('minimum_order')->default(1);
            $table->integer('maxima_order')->nullable();
            $table->string('main_image');
            $table->text('images');
            $table->integer('in_stock')->default(1);
            $table->integer('pre_order')->default(0);
            $table->unsignedInteger('brand_id')->references('id')->on('brands')->nullable();
            $table->integer('is_featured')->default(0);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('products');
    }
}
