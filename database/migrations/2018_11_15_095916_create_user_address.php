<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address_type');
            $table->string('user_label')->nullable();
            $table->string('first_address')->nullable();
            $table->string('second_address')->nullable();
            $table->unsignedBigInteger('user_id')->references('id')->on('users');      
            $table->string('mobile_no')->nullable();            
            $table->string('phone_no')->nullable();          
            $table->unsignedBigInteger('governorate_id')->references('id')->on('governorates');
            $table->integer('is_default')->default(0);
            $table->string('city')->nullable();
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
        //
    }
}
