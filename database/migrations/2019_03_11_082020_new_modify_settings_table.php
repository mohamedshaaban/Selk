<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewModifySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('banner_home')->nullable();
            $table->string('banner_product_listing')->nullable();
            $table->string('banner_product_details')->nullable();
            $table->string('banner_categories_listing')->nullable();
            $table->string('banner_characters_listing')->nullable();
            $table->string('banner_cart')->nullable();
            $table->string('banner_checkout')->nullable();
            $table->string('banner_user_account')->nullable();
            $table->string('banner_editaddresss')->nullable();
            $table->string('banner_address_list')->nullable();
            $table->string('banner_notification_setting')->nullable();
            $table->string('banner_order_details')->nullable();
            $table->string('banner_order_history')->nullable();
            $table->string('banner_wishlist')->nullable();
            $table->string('banner_login')->nullable();
         
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
