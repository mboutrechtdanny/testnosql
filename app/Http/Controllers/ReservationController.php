<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function create()
    {
        $ticket_types = \DB::table('ticket_types')->get();
        $maaltijd_types = \DB::table('maaltijd_types')->get();

        return view('reservation', [
            'ticket_types' => $ticket_types,
            'maaltijd_types' => $maaltijd_types,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = \Validator::make($data, [
            'naam' => 'required',
            'email' => 'required|email',
            'payment' => 'required',
        ]);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $ticket_types = \DB::table('ticket_types')->get();

        $ticket_count = 0;
        foreach ($ticket_types as $ticket_type) {
            $ticket_count += abs($request->get('ticket-' . $ticket_type->id));
        }
        if ($ticket_count > 10) {
            return redirect()
                ->back()->withInput()
                ->withErrors('U mag maximaal 10 tickets bestellen');
        }

        $total_price = 0;
        $tickets = [];
        $meals = [];

        //todo: add check if on this day tickets bought are less than 250

        foreach ($ticket_types as $ticket_type) {

            $ticket_type_count = $request->get('ticket-' . $ticket_type->id);

            if (intval($ticket_type_count) > 0) {

                for ($i = 0; $i < $ticket_type_count; $i++) {

                    $tickets[] = [
                        'type' => $ticket_type->id,
                        'titel' => $ticket_type->titel,
                        'prijs' => $ticket_type->prijs,
                        'prioriteit' => $ticket_type->prioriteit,
                        'token' => uniqid('t_'),
                    ];

                    $total_price += $ticket_type->prijs;
                }
            }
        }

        if (count($tickets)) {

            $meal_types = \DB::table('maaltijd_types')->get();

            $meal_count = 0;
            foreach ($meal_types as $meal_type) {
                $meal_count += abs($request->get('maaltijd-' . $meal_type->id));
            }

            if ($meal_count > 10) {
                return redirect()
                    ->back()->withInput()
                    ->withErrors('U mag maximaal 10 maaltijden bestellen');
            }

            foreach ($meal_types as $meal_type) {

                $meal_type_count = $request->get('maaltijd-' . $meal_type->id);

                if (intval($meal_type_count) > 0) {

                    for ($i = 0; $i < $meal_type_count; $i++) {

                        $meals[] = [
                            'type' => $meal_type->id,
                            'titel' => $meal_type->titel,
                            'prijs' => $meal_type->prijs,
                            'omschrijving' => $meal_type->omschrijving,
                            'tijdstart' => $meal_type->tijdstart,
                            'tijdeind' => $meal_type->tijdeind,
                            'vegetarisch' => $meal_type->vegetarisch,
                            'token' => uniqid('m_'),
                        ];

                        $total_price += $meal_type->prijs;
                    }
                }
            }

            // GENERATE PDF

            // mongoDb document insert
            $reservation = Reservation::create([
                'payment' => $request->get('payment'),
                'prijs' => $total_price,
                'bezoeker' => [
                    'naam' => $request->get('naam'),
                    'email' => $request->get('email'),
                    'straat' => 'Kanaalweg 32',
                    'postcode' => '3242 DD',
                    'woonplaats' => 'Utrecht',
                    'telefoon' => '042-2321123',
                ],
                'tickets' => $tickets,
                'maaltijden' => $meals
            ]);

            $pdf = \PDF::loadView('pdf.reservation', [
                'tickets_chunks' => array_chunk($reservation['tickets'], 3),
                'maaltijden_chunks' => array_chunk($reservation['maaltijden'], 3),
                'bezoeker' => $reservation['bezoeker'],
                'reservatie' => $reservation,
                'prijs' => $total_price,
            ]);

            // SEND EMAIL
            $email = $reservation['bezoeker']['email'];

            \Mail::send('emails.reservation', [
                'bezoeker' => $reservation['bezoeker'],
                'reservatie' => $reservation,
                'ticket_count' => count($reservation['tickets']),
                'maaltijd_count' => count($reservation['maaltijden']),
                'prijs' => $total_price,
            ],
                function ($message) use ($pdf, $email) {
                    $message->from('buster@site.com', 'Buster');

                    $message->to($email);
                    $message->subject('Uw reservering voor de conferentie');

                    $message->attachData($pdf->output(), "reservering.pdf");
                });

            \Session::flash('message_type', 'success');
            \Session::flash('message', "U heeft succesvol gereserveerd!<br> De ticket en maaltijd bonnen zijn naar uw emailadres verstuurd.");

            return redirect('/');
        }

        return redirect()
            ->back()->withInput()
            ->withErrors('Er moet minimaal 1 ticket gekocht worden');
    }

}
