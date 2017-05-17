<?php

use App\Slot;
use Illuminate\Database\Seeder;

class SlotsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		DB::table('dagen')->truncate();
		DB::table('slots')->truncate();

		$times_start = [
			['12:15', '13:30', '15:00', '16:15',],
			['12:15', '13:30', '15:00', '16:15',],
			['13:15', '13:30', '15:00', '16:15',],
			['10:15', '13:30', '15:00', '16:15',],
			['11:15', '13:30', '15:00', '16:15',],
			['12:15', '13:30', '15:00', '16:15',],
			['6:15', '13:30', '15:00', '16:15',],
			['5:15', '13:30', '15:00', '16:15',],
		];
		$times_end = [
			['13:15', '14:30', '16:00', '17:15',],
			['13:10', '14:45', '16:30', '17:40',],
			['13:15', '14:15', '15:00', '18:15',],
			['11:15', '14:10', '16:00', '17:15',],
			['12:15', '14:20', '16:00', '17:15',],
			['14:15', '14:40', '15:00', '17:15',],
			['9:15', '14:30', '18:00', '19:15',],
			['6:15', '14:30', '16:00', '17:15',],
		];

		$slot_status = ['open', 'voorbehoud', 'bezet'];

		$slots = [];
		$now = \Carbon\Carbon::now(config('app.timezone'))->toDateTimeString();

		for ($i = 0; $i < 3; $i++) {
			$dag = DB::table('dagen')->insertGetId([
				'datum' => \Carbon\Carbon::create(2016, 11, 4 + $i)
			]);

			for ($j = 0; $j < 4; $j++) {

				//zalen
				for ($zaal = 0; $zaal < 4; $zaal++) {

					// to show the system won't fail when missing slots on particular days
//					if(rand(0, 10) < 6){

						$slots[] = [
							'zaal' => $zaal + 1,
							'dag' => $dag,
							'tijdstart' => $times_start[$i][$j],
							'tijdeind' => $times_end[$i][$j],
							'status' => $slot_status[0/*$faker->numberBetween(0, 2)*/],
							'created_at' => $now,
							'updated_at' => $now,
						];
//					}

				}

			}
		}

		Slot::insert($slots);

	}
}
