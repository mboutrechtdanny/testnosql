<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoorreservatiesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('voorreservaties', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('bezoeker')->unsigned();
			$table->integer('slot')->unsigned();
			$table->integer('reservering')->nullable()->unsigned();
			$table->timestamps();
			$table->foreign('bezoeker')->references('id')->on('bezoekers');
			$table->foreign('slot')->references('id')->on('slots');
			$table->foreign('reservering')->references('id')->on('reservaties');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('voorreservaties');
	}
}
