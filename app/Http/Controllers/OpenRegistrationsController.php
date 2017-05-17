<?php

namespace App\Http\Controllers;

use App\Aanvraag;
use App\Slot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OpenRegistrationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $aanvragen = Aanvraag::orderBy('deadline')
            ->join('sprekers', 'spreker_id', '=', 'sprekers.id')
            ->join('slots', 'slot_id', '=', 'slots.id');

        $budget = \DB::table('sprekers_budget')->first();

        if (!$budget) {
            \DB::table('sprekers_budget')->insert([
                'budget_start' => 25000,
                'budget' => 25000,
            ]);

            $budget = \DB::table('sprekers_budget')->first();
        }

        if ($request->get('show') == 'all') {

        } else {
            $aanvragen = $aanvragen->where('status', '=', 'voorbehoud');
        }

        $aanvragen = $aanvragen->get([
            'aanvragen.id',
            'onderwerp',
            'beschrijving',
            'deadline',
            'kosten',
            'status',
            'naam',
            'wensen',
            'slot_id',
            'spreker_id as aanvraag_spreker_id',
            'slots.spreker as slot_spreker_id',
        ]);

        return view('open-registrations', [
            'aanvragen' => $aanvragen,
            'budget' => $budget,
        ]);
    }

    public function show($aanvraagId)
    {
        $aanvraag = Aanvraag::where(['aanvragen.id' => $aanvraagId])
            ->join('sprekers', 'spreker_id', '=', 'sprekers.id')
            ->join('slots', 'slot_id', '=', 'slots.id')
            ->get([
                'aanvragen.id',
                'onderwerp',
                'beschrijving',
                'deadline',
                'kosten',
                'status',
                'naam',
                'wensen',
                'slot_id',
                'spreker_id as aanvraag_spreker_id',
                'slots.spreker as slot_spreker_id',
            ])->first();

        $budget = \DB::table('sprekers_budget')->first();

        return view('open-registrations-show', [
            'aanvraag' => $aanvraag,
            'budget' => $budget,
        ]);
    }

    public function negotiate($aanvraagId)
    {
        $aanvraag = Aanvraag::where(['aanvragen.id' => $aanvraagId])
            ->join('sprekers', 'spreker_id', '=', 'sprekers.id')
            ->join('slots', 'slot_id', '=', 'slots.id')
            ->get([
                'aanvragen.id',
                'onderwerp',
                'beschrijving',
                'deadline',
                'kosten',
                'status',
                'naam',
                'email',
                'slot_id',
                'spreker_id as aanvraag_spreker_id',
                'slots.spreker as slot_spreker_id',
            ])->first();

        return view('open-registrations-negotiate', [
            'aanvraag' => $aanvraag,
        ]);
    }

    public function negotiateStore(Request $request, $aanvraagId)
    {

        $aanvraag = Aanvraag::where(['aanvragen.id' => $aanvraagId])
            ->join('sprekers', 'spreker_id', '=', 'sprekers.id')
            ->join('slots', 'slot_id', '=', 'slots.id')
            ->get([
                'kosten',
                'naam',
                'email',
            ])->first();

        $vandaag = Carbon::today();

        $negotiation_insert = [
            'aanvraag_id' => $aanvraagId,
            'spreker_aanbod' => $aanvraag->kosten,
            'nieuw_aanbod' => $request->get('nieuwe_kosten'),
            'expiry_day' => $vandaag->addDays(2),
            'token' => uniqid(),
        ];
        \DB::table('aanvragen_negotiate')->insert($negotiation_insert);

        \Mail::send('emails.negotiation', [
            'aanvraag' => $aanvraag,
            'negotiation' => $negotiation_insert,
        ],
            function ($message) use ($aanvraag) {
                $message->from('buster@site.com', 'Buster');

                $message->to($aanvraag->email);
                $message->subject('Uw spreker kosten moeten worden onderhandeld');
            });

        \Session::flash('message_type', 'success');
        \Session::flash('message', 'U heeft de onderhandeling verstuurd');

        return redirect('/open-registrations');
    }

    public function accept($aanvraagId, $accept)
    {
        $aanvraag = Aanvraag::findOrFail($aanvraagId);
        $slot = Slot::findOrFail($aanvraag->slot_id);

        if ($accept) {
            $slot->status = 'bezet';
            $slot->spreker = $aanvraag->spreker_id;
        } else {
            $slot->status = 'open';
            $slot->spreker = null;
        }

        $slot->save();
        $this->updateBudget();

        // zorg ervoor dat sprekers hun slot niet meer kunnen bezetten
        \DB::table('aanvragen_negotiate')
            ->where('aanvraag_id', '=', $aanvraag->id)
            ->delete();

        return redirect()->back();
    }

    private function updateBudget()
    {
        $kostenArr = Slot::whereNotNull('spreker')
            ->join('aanvragen', 'slots.id', '=', 'slot_id')
            ->pluck('kosten')->toArray();

        $sum = array_sum($kostenArr);

        $startbudget = \DB::table('sprekers_budget')
            ->first(['budget_start'])->budget_start;
        \DB::table('sprekers_budget')
            ->update(['budget' => $startbudget - $sum]);
    }

    public function budgetUpdate(Request $request)
    {
        $new_budget = $request->get('new_budget');

        \DB::table('sprekers_budget')->update(['budget_start' => $new_budget]);

        \Session::flash('message_type', 'success');
        \Session::flash('message', 'Sprekers budget geupdate');

        $this->updateBudget();

        return redirect()->back();
    }

}
