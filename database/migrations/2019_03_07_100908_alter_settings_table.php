<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSettingsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'settings', function ( Blueprint $table ) {
			$table->integer( 'default_qty' )->default( 0 );
			$table->integer( 'max_order' )->default( 0 );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'settings', function ( Blueprint $table ) {
			$table->dropColumn( 'default_qty' );
			$table->dropColumn( 'max_order' );
		} );
	}
}
