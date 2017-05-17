<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAanvragenTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('aanvragen', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('slot_id')->unsigned();
			$table->integer('spreker_id')->unsigned();
			$table->float('kosten')->default(0);
			$table->dateTime('deadline');
			$table->string('onderwerp');
			$table->string('beschrijving');
			$table->string('wensen');
			$table->timestamps();

			$table->foreign('slot_id')->references('id')->on('slots');
			$table->foreign('spreker_id')->references('id')->on('sprekers');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('aanvragen');
	}
}
