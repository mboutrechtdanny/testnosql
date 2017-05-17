<?php

namespace App\Http\Controllers;

use App\Aanvraag;
use App\Slot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NegotiationController extends Controller {

	public function negotiate(Request $request) {

		$req = $request->all();

		$token = $req['t'];
		$accept = $req['a'];

		$negotiation = \DB::table('aanvragen_negotiate')
			->where('token', '=', $token)
			->first();

		if ($negotiation) {

			$today = Carbon::today();
			$expiry_day = $negotiation->expiry_day;

			if ($today > $expiry_day) {
				return 'Deze onderhandeling is verlopen';
			}

			// nu moeten we de organisator rol overnemen
			// deze route 'OpenRegistrationsController@accept' simuleren

			$aanvraag = Aanvraag::findOrFail($negotiation->aanvraag_id);
			$slot = Slot::findOrFail($aanvraag->slot_id);

			if ($accept) {
				$slot->status = 'bezet';
				$slot->spreker = $aanvraag->spreker_id;

				// aanvraag prijs updaten naar overeenkomst
				$aanvraag->kosten = $negotiation->nieuw_aanbod;
			}
			else {
				$slot->status = 'open';
				$slot->spreker = null;
			}

			$slot->save();
			$aanvraag->save();

			// sprekers budget updaten aan de hand van slots
			$this->updateBudget();

			// zorg ervoor dat sprekers hun slot niet meer kunnen bezetten
			\DB::table('aanvragen_negotiate')
				->where('aanvraag_id', '=', $aanvraag->id)
				->delete();

			\Session::flash('message_type', 'success');
			\Session::flash('message', 'U heeft de onderhandeling afgehandeld met de organisator');

			return redirect('/');
		}

		return 'Oeps, er ging iets fout';

	}

	private function updateBudget() {
		$kostenArr = Slot::whereNotNull('spreker')
			->join('aanvragen', 'slots.id', '=', 'slot_id')
			->pluck('kosten');

		$totaleKosten = 0;
		foreach ($kostenArr as $kosten) {
			$totaleKosten += $kosten;
		}

		$startbudget = \DB::table('sprekers_budget')
			->first(['budget_start'])->budget_start;
		\DB::table('sprekers_budget')
			->update(['budget' => $startbudget - $totaleKosten]);
	}

}
