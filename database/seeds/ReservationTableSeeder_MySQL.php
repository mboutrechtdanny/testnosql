<?php

use App\Bezoeker;
use App\Maaltijd;
use App\Reservation;
use App\Ticket;
use Illuminate\Database\Seeder;

class ReservationTableSeeder_MySQL extends Seeder
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

            $b = Bezoeker::create([
                'naam' => $faker->word,
                'email' => $faker->email,
            ]);

            $r = Reservation::create([
                'payment' => ['iDeal', 'Bank', 'Credit-card'][rand(0, 2)],
                'prijs' => $faker->numberBetween(50, 200),
                'bezoeker' => $b->id
            ]);

            Ticket::create([
                'reservatie' => $r->id,
                'ticket_type' => 1,
                'token' => uniqid('t_'),
            ]);

            Ticket::create([
                'reservatie' => $r->id,
                'ticket_type' => 2,
                'token' => uniqid('t_'),
            ]);

            Maaltijd::create([
                'reservatie' => $r->id,
                'maaltijd_type' => 1,
                'token' => uniqid('m_'),
            ]);

            Maaltijd::create([
                'reservatie' => $r->id,
                'maaltijd_type' => 2,
                'token' => uniqid('m_'),
            ]);

        }

    }
}
