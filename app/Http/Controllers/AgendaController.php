<?php

namespace App\Http\Controllers;

use App\Slot;
use DateTime;
use Illuminate\Http\Request;

class AgendaController extends Controller
{

    public function index()
    {
        return view('agenda');
    }

    public function getSlotsByDay(Request $request)
    {

        $date = new DateTime($request->get('date'));

        $dag = \DB::table('dagen')
            ->where('datum', '=', $date->format('Y-m-d'))
            ->first();

        if ($dag) {
            $slots = Slot::whereDag($dag->id)
                ->join('zalen', 'zaal', '=', 'zalen.id')
                ->leftJoin('sprekers', 'spreker', '=', 'sprekers.id')
                ->leftJoin('aanvragen', 'spreker', '=', 'aanvragen.spreker_id')
                ->orderBy('zaal')
                ->orderBy('tijdstart')
                ->distinct()// zorgt ervoor dat er niet meerdere slots meekomen (alleen eerste)
                ->get([
                    'slots.id',
                    'spreker',
                    'naam',
                    'email',
                    'adres',
                    'zaal',
                    'dag',
                    'tijdstart',
                    'tijdeind',
                    'status',
                    'aanvragen.beschrijving as aanvraag_beschrijving',
                    'aanvragen.onderwerp as aanvraag_onderwerp',
                    'zalen.beschrijving as zaal_beschrijving' // van zalen
                ]);

            $slots->each(function ($slot) {

                // pas als het slot een spreker heeft laten we de tags zien

                if ($slot['spreker']) {
                    $tags = \DB::table('slots_tags')
                        ->where('slot_id', '=', $slot['id'])
                        ->join('tags', 'slots_tags.tag_id', '=', 'tags.id')
                        ->pluck('beschrijving');
                    $slot['slots_tags'] = $tags;
                }
            });

            return response()->json(['dag' => $dag, 'slots' => $slots]);
        }

        return response()->json([], 404);
    }

    public function search(Request $request)
    {
        $search = $request->get('q');

        $results = \DB::table('tags')
            ->where('tags.beschrijving', '=', $search)
            ->join('slots_tags', 'tag_id', '=', 'tags.id')
            ->join('slots', 'slots.id', '=', 'slot_id')
            ->join('aanvragen', 'aanvragen.slot_id', '=', 'slots_tags.slot_id')
            ->whereNotNull('spreker')
            ->get([
                'aanvragen.beschrijving as aanvraag_beschrijving',
                'tags.beschrijving as tag_beschrijving',
                'zaal',
                'dag',
                'spreker',
                'tijdstart',
                'tijdeind',
                'status',
                'spreker_id',
                'kosten',
                'deadline',
                'onderwerp',
                'wensen',
            ]);

        return view('search', [
            'results' => $results
        ]);

    }

}
