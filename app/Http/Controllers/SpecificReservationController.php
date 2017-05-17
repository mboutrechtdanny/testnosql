<?php

namespace App\Http\Controllers;

use App\Slot;
use App\Spreker;
use DateTime;
use Illuminate\Http\Request;

class SpecificReservationController extends Controller {

	public function create() {

		return view('specific-reservation');

	}

	public function getSlotsByDay(Request $request) {

		$date = new DateTime($request->get('date'));

		$dag = \DB::table('dagen')
			->where('datum', '=', $date->format('Y-m-d'))
			->first();

		if ($dag) {
			$slots = Slot::whereDag($dag->id)
				->join('zalen', 'zaal', '=', 'zalen.id')
				->orderBy('zaal')
				->orderBy('tijdstart')
				->get([
					'slots.id',
					'spreker',
					'zaal',
					'dag',
					'tijdstart',
					'tijdeind',
					'status',
					'beschrijving' // van zalen
				]);

			$slots->each(function ($slot) {
				if ($slot['spreker'] !== null) {
					$slot['spreker'] = Spreker::find($slot['spreker'], [
						'naam',
						'email',
						'adres'
					]);
				}
			});

			return response()->json(['dag' => $dag, 'slots' => $slots]);
		}

		return response()->json([], 404);
	}

	public function store() {

	}

}
