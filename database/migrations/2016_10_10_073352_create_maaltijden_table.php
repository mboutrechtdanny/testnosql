<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaaltijdenTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('maaltijden', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('reservatie')->unsigned();
			$table->integer('maaltijd_type')->unsigned();
			$table->string('token');

			$table->timestamps();

			$table->foreign('reservatie')->references('id')->on('reservaties');
			$table->foreign('maaltijd_type')->references('id')->on('maaltijd_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('maaltijden');
	}
}
