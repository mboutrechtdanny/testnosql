<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlotsTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('slots_tags', function (Blueprint $table) {
			$table->integer('slot_id')->unsigned();
			$table->integer('tag_id')->unsigned();

			$table->foreign('slot_id')->references('id')->on('slots');
			$table->foreign('tag_id')->references('id')->on('tags');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('slots_tags');
    }
}
