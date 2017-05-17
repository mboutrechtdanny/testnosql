<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('tickets', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('reservatie')->unsigned();
			$table->integer('ticket_type')->unsigned();
			$table->string('token');
			$table->timestamps();

			$table->foreign('reservatie')->references('id')->on('reservaties');
			$table->foreign('ticket_type')->references('id')->on('ticket_types');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tickets');
    }
}
