<?php

use Illuminate\Database\Seeder;

class SprekersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		DB::table('sprekers')->insert([
			'naam' => 'buster',
			'email' => 'ewefwe@gmail.com',
			'adres' => 'ewfwef'
		]);

	}
}
