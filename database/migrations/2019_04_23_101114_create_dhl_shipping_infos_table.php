<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDhlShippingInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhl_shipping_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->string('global_product_code');
            $table->string('local_product_code');
            $table->float('cost')->nullable();
            $table->string('title')->nullable();
            $table->string('date')->nullable();
            $table->integer('days')->nullable();
            $table->string('currency')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('service')->nullable();
            $table->string('label_file')->nullable();
            $table->string('confirmation_number')->nullable();
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
        Schema::dropIfExists('dhl_shipping_infos');
    }
}
