<?php

use App\Reservation;
use Illuminate\Database\Seeder;

class ReservationTableSeeder_MongoDB extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {

            Reservation::create([
                'payment' => ['iDeal', 'Bank', 'Credit-card'][rand(0, 2)],
                'prijs' => $faker->numberBetween(50, 200),
                'bezoeker' => [
                    '_id' => $faker->numberBetween(1, 100),
                    'naam' => $faker->word,
                    'email' => $faker->email,
                    'straat' => $faker->streetName,
                    'postcode' => $faker->postcode,
                    'woonplaats' => $faker->address,
                    'telefoon' => $faker->phoneNumber,
                ],
                'tickets' => [
                    [
                        'titel' => 'Vrijdag',
                        'prijs' => 45,
                        'prioriteit' => 1,
                        'token' => uniqid('t_'),
                    ],
                    [
                        'titel' => 'Passe-partout',
                        'prijs' => 100,
                        'prioriteit' => 2,
                        'token' => uniqid('t_'),
                    ],
                ],
                'maaltijden' => [
                    [
                        'titel' => 'Lunch',
                        'prijs' => 20,
                        'omschrijving' => 'Alle drie dagen',
                        'tijdstart' => '12:00:00',
                        'tijdeind' => '13:30:00',
                        'vegetarisch' => false,
                        'token' => uniqid('m_'),
                    ],
                    [
                        'titel' => 'Diner',
                        'prijs' => 30,
                        'omschrijving' => 'Alleen weekend',
                        'tijdstart' => '17:30:00',
                        'tijdeind' => '20:00:00',
                        'vegetarisch' => false,
                        'token' => uniqid('m_'),
                    ],
                ]
            ]);

        }

    }
}
