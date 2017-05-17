<?php

namespace App\Http\Controllers;

use App\Aanvraag;
use App\Slot;
use App\Spreker;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class RegistrationController extends Controller {

	public function create() {

		$wishes = [
			'beamer',
			'smartboard',
			'microfoon',
			'laptop'
		];

		return view('registration', ['wishes' => $wishes]);
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
					'zaal',
					'dag',
					'tijdstart',
					'tijdeind',
					'status',
					'beschrijving' // van zalen
				]);

			return response()->json(['dag' => $dag, 'slots' => $slots]);
		}

		return response()->json([], 404);
	}

	public function store(Request $request) {

		$validator = \Validator::make($request->all(), [
			'chosen-slot-id' => 'required',
			'chosen-slots-in-progress-ids' => '',
			'name' => 'required',
			'email' => 'required|email',
			'address' => 'required',
			'subject' => 'required',
			'kosten' => 'numeric|between:0,999999.99',
			'description' => '',
			'wishes' => '',
		]);

		if ($validator->fails()) {
			$this->throwValidationException($request, $validator);
		}

		$spreker = Spreker::create([
			'naam' => $request->get('name'),
			'email' => $request->get('email'),
			'adres' => $request->get('address'),
		]);

		$aanvraag_data = [
			'spreker_id' => $spreker->id,
			'deadline' => Carbon::now()->addDays(8),
			'kosten' => strlen($request->get('kosten')) > 0 ? $request->get('kosten') : 0,
			'onderwerp' => $request->get('subject'),
			'beschrijving' => $request->get('description'),
			'wensen' => implode(',', $request->get('wishes') ? $request->get('wishes') : []),
		];

		$insert_slot_aanvraag = function ($id) use ($aanvraag_data) {

			Slot::whereId($id)->update(['status' => 'voorbehoud']);

			Aanvraag::create(array_merge($aanvraag_data, ['slot_id' => $id]));

		};

		$chosen_slot = $request->get('chosen-slot-id');
		$chosen_slots_extra = explode(',', $request->get('chosen-slots-in-progress-ids'));

		\DB::beginTransaction();

		// hier inserten we het eerste slot
		$insert_slot_aanvraag($chosen_slot);

		// hier inserten we de extra / onder voorbehoud slots
		foreach ($chosen_slots_extra as $slot) {
			if (intval($slot) > 0) {
				$insert_slot_aanvraag($slot);
			}
		}

		// insert database
		\DB::commit();

		\Session::flash('message_type', 'success');
		\Session::flash('message', 'U heeft zich succesvol geregistreerd voor de slot(s).');

		return redirect('/');
	}
}
