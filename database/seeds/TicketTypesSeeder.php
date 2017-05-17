<?php

use Illuminate\Database\Seeder;

class TicketTypesSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('ticket_types')->truncate();

		DB::table('ticket_types')->insert([
			'titel' => 'Vrijdag',
			'prijs' => '45',
			'prioriteit' => 1,
		]);
		DB::table('ticket_types')->insert([
			'titel' => 'Zaterdag',
			'prijs' => '60',
			'prioriteit' => 1,
		]);
		DB::table('ticket_types')->insert([
			'titel' => 'Zondag',
			'prijs' => '30',
			'prioriteit' => 1,
		]);
		DB::table('ticket_types')->insert([
			'titel' => 'Passe-partout',
			'prijs' => '100',
			'prioriteit' => 2,
		]);
		DB::table('ticket_types')->insert([
			'titel' => 'Zaterdag & zondag',
			'prijs' => '80',
			'prioriteit' => 1,
		]);
	}
}