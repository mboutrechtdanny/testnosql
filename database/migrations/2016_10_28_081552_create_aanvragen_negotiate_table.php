<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAanvragenNegotiateTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('aanvragen_negotiate', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('aanvraag_id')->unsigned();
			$table->float('spreker_aanbod');
			$table->float('nieuw_aanbod');
			$table->date('expiry_day');
			$table->string('token');
			$table->foreign('aanvraag_id')->references('id')->on('aanvragen');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('aanvragen_negotiate');
	}
}
