<?php

use Illuminate\Database\Seeder;

class ZalenTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('zalen')->truncate();

		DB::table('zalen')->insert([
			'beschrijving' => 'Zaal 1',
		]);
		DB::table('zalen')->insert([
			'beschrijving' => 'Zaal 2 (groot)',
		]);
		DB::table('zalen')->insert([
			'beschrijving' => 'Zaal 3',
		]);
		DB::table('zalen')->insert([
			'beschrijving' => 'Zaal 4',
		]);
	}
}
