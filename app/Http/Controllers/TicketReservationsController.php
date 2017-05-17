<?php

namespace App\Http\Controllers;

use App\Maaltijd;
use App\Ticket;

class TicketReservationsController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {

		//todo: overzicht van gekochte tickets (extra opdracht)

		$ticket_types_counts = \DB::table('ticket_types')->get();

		$ticket_types_counts->each(function ($ticket_type) {
			$ticket_type->count = Ticket::whereTicketType($ticket_type->id)
				->count();
		});

		$meal_types_counts = \DB::table('maaltijd_types')->get();

		$meal_types_counts->each(function ($meal_type) {
			$meal_type->count = Maaltijd::whereMaaltijdType($meal_type->id)
				->count();
		});

		return view('ticket-reservations', [
			'ticket_counts' => $ticket_types_counts,
			'meal_counts' => $meal_types_counts,
		]);

	}

}
