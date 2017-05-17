<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaaltijdTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('maaltijd_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('titel');
			$table->float('prijs');
			$table->string('omschrijving');
			$table->time('tijdstart');
			$table->time('tijdeind');
			$table->boolean('vegetarisch');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('maaltijd_types');
	}
}
