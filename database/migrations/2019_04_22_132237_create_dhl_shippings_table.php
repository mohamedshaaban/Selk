<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDhlShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhl_shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status');
            $table->integer('is_test');
            $table->string('access_id');
            $table->string('password');
            $table->string('account_number');
            $table->string('weight_unit');

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
        Schema::dropIfExists('dhl_shippings');
    }
}
