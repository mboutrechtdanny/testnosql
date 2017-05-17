<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$tags = [
			'Preprocessors',
			'Bootstrap',
			'ships',
			'with',
			'vanilla',
			'CSS,',
			'but',
			'its',
			'source',
			'code',
			'utilizes',
			'the',
			'two',
			'most',
			'popular',
			'CSS',
			'preprocessors',
			'Less',
			'and',
			'Sass.',
			'Quickly',
			'get',
			'started',
			'with',
			'pre-compiled',
			'CSS',
			'build',
			'source',
			'Responsive',
			'across',
			'devices',
			'One',
			'framework,',
			'every',
			'device',
			'Bootstrap',
			'easily',
			'efficiently',
			'scales',
			'your',
			'websites',
			'applications',
			'with',
			'single',
			'code',
			'base,',
			'phones',
			'tablets',
			'desktops',
			'with',
			'CSS',
			'media',
			'queries',
			'Components',
			'Full',
			'features',
			'With',
			'Bootstrap,',
			'you',
			'extensive',
			'beautiful',
			'documentation',
			'common',
			'HTML',
			'elements',
			'dozens',
			'custom',
			'HTML',
			'CSS',
			'components',
			'awesome',
			'jQuery',
			'plugins'
		];

//		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		DB::table('tags')->delete();
//		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$faker = Faker::create();

		for ($i = 0; $i < 50; $i++) {

			DB::table('tags')->insert([
				'beschrijving' => $tags[$i],
			]);

		}
	}
}
