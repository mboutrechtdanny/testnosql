<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservatiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reservaties', function (Blueprint $table) {
			$table->increments('id');
			$table->string('payment');
			$table->float('prijs')->nullable();
			$table->integer('bezoeker')->unsigned();
			$table->timestamps();

			$table->foreign('bezoeker')->references('id')->on('bezoekers');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reservaties');
	}
}
