<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->truncate();

		\App\User::create([
			'name' => str_random(10),
			'email' => 'busterdebeer@gmail.com',
			'password' => bcrypt('p'),
		]);

	}
}
