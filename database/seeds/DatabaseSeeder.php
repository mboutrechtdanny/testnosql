<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$this->call(UsersTableSeeder::class);
		$this->call(TicketTypesSeeder::class);
		$this->call(MaaltijdTypesSeeder::class);
		$this->call(TagsTableSeeder::class);

		$this->call(ZalenTableSeeder::class);
		$this->call(SlotsTableSeeder::class);

//		$this->call(ReservationTableSeeder::class);

		//todo:seeder , zoeken
		for ($i = 1; $i < 20; $i++) {
			DB::table('slots_tags')->insert([
				'slot_id' => $i,
				'tag_id' => $i
			]);
		}

		DB::table('sprekers_budget')->insert([
			'budget' => 25000,
			'budget_start' => 25000,
		]);

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
