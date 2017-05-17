<?php

use Illuminate\Database\Seeder;

class AanvragenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('aanvragen')->insert([
			'spreker' => 1,
			'deadline' => \Carbon\Carbon::tomorrow(),
			'onderwerp' => 'wefwef',
			'beschrijving' => 'wefwef',
			'wensen' => 'wefwef',
		]);

	}
}
