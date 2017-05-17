<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlotsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('slots', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('zaal')->unsigned();
			$table->integer('dag')->unsigned();
			$table->integer('spreker')->nullable()->unsigned();
			$table->time('tijdstart');
			$table->time('tijdeind');
			$table->string('status');
			$table->timestamps();
			$table->foreign('zaal')->references('id')->on('zalen');
			$table->foreign('dag')->references('id')->on('dagen');
			$table->foreign('spreker')->references('id')->on('sprekers');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('slots');
	}
}
