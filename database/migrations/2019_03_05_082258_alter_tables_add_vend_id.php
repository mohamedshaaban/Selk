<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablesAddVendId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('supplier_id')->references('id')->on('suppliers')->after('status')->nullable();
            $table->float('height')->after('status')->nullable();
            $table->float('weight')->after('status')->nullable();
           // $table->integer('maxima_order')->after('minimum_order')->nullable();
            $table->integer('free_return')->default(1);
            $table->integer('pre_order_days')->after('status')->nullable();
            $table->string('vend_id')->after('status')->nullable()->index();
            $table->integer('vend_tracking_inventory')->after('status')->nullable();
            $table->float('vend_supplier_price')->after('status')->nullable();
            $table->float('vend_price')->after('status')->nullable();
            $table->dateTime('vend_updated_at')->after('status')->nullable();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('vend_id')->after('parent_id')->nullable()->index();
            $table->dateTime('vend_updated_at')->after('parent_id')->nullable();
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->string('vend_id')->after('status')->nullable()->index();
            $table->dateTime('vend_updated_at')->after('status')->nullable();
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->string('vend_id')->after('status')->nullable()->index();
            $table->dateTime('vend_updated_at')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('vend_id');
            $table->dropColumn('height');
            $table->dropColumn('weight');
            $table->dropColumn('free_return');
            $table->dropColumn('pre_order_days');
            $table->dropColumn('vend_tracking_inventory');
            $table->dropColumn('vend_supplier_price');
            $table->dropColumn('vend_price');
            $table->dropColumn('vend_updated_at');
            $table->dropColumn('maxima_order');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('vend_id');
            $table->dropColumn('vend_updated_at');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('vend_id');
            $table->dropColumn('vend_updated_at');
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('vend_id');
            $table->dropColumn('vend_updated_at');
        });
    }
}
