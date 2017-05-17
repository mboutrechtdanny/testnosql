<?php

use Illuminate\Database\Seeder;

class MaaltijdTypesSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('maaltijd_types')->truncate();

		DB::table('maaltijd_types')->insert([
			'titel' => 'Lunch',
			'prijs' => '20',
			'omschrijving' => 'Alle drie dagen',
			'tijdstart' => '12:00',
			'tijdeind' => '13:30',
			'vegetarisch' => false,
		]);
		DB::table('maaltijd_types')->insert([
			'titel' => 'Diner',
			'prijs' => '30',
			'omschrijving' => 'Alleen weekend',
			'tijdstart' => '17:30',
			'tijdeind' => '20:00',
			'vegetarisch' => false,
		]);
		DB::table('maaltijd_types')->insert([
			'titel' => 'Lunch Vegetarisch',
			'prijs' => '18',
			'omschrijving' => 'Alle drie dagen',
			'tijdstart' => '12:00',
			'tijdeind' => '13:30',
			'vegetarisch' => true,
		]);
		DB::table('maaltijd_types')->insert([
			'titel' => 'Diner Vegetarisch',
			'prijs' => '27',
			'omschrijving' => 'Alleen weekend',
			'tijdstart' => '17:30',
			'tijdeind' => '20:00',
			'vegetarisch' => true,
		]);

	}
}