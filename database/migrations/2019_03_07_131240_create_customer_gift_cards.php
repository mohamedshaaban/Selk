<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerGiftCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_gift_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card_id')->nullable();
            $table->string('user_id')->nullable();
            $table->text('card')->nullable();
            $table->text('amount')->nullable();
            $table->text('email')->nullable();
            $table->integer('is_used')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_gift_cards', function (Blueprint $table) {
            //
        });
    }
}
