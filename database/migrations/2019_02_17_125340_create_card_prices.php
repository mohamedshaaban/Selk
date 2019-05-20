<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_prices', function (Blueprint $table) {
               $table->increments('id');
               $table->unsignedInteger('card_id')->references('id')->on('gift_cards')->default(0);
               $table->integer('amount')->nullable();
                 $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('gift_cards', function (Blueprint $table) {
               $table->text('card_number')->nullable();
              
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('card_prices', function (Blueprint $table) {
            //
        });
    }
}
