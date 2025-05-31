<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Agenda;
use App\Models\Tijd;
use App\Models\Straat;
use App\Models\User;


class AgendaController extends Controller
{ //ophalen van gegevens
    public function index(Request $request)
{
    $weekOffset = (int) $request->query('week', 0);
    $locatieNaam = $request->query('locatie', 'Merestraat');
    $straat = Straat::where('naam', $locatieNaam)->firstOrFail();
    $straatId = $straat->id;

    // Start van de week (maandag)
    $startDatum = now()->startOfWeek()->addWeeks($weekOffset);
    $eindDatum = $startDatum->copy()->addDays(6);

    // Inschrijvingen ophalen voor de juiste week en straat
    $agendas = Agenda::with('user', 'tijd', 'straat')
        ->whereBetween('datum', [$startDatum, $eindDatum])
        ->where('straat_id', $straatId)
        ->get();

    $agendaItems = [];

    foreach ($agendas as $item) {
        $dag = $item->datum->format('Y-m-d');
        $moment = strtolower($item->tijd->moment); 
        $naam = $item->user->name;

        $agendaItems[$dag][$moment][] = $naam;
    }

    return view('agenda.index', [
        'agendaItems' => $agendaItems,
        'startDatum' => $startDatum,
        'weekOffset' => $weekOffset,
        'locatie' => $locatieNaam,
        'straatId' => $straatId,
    ]);
}

 // toevoegen knop
    public function store(Request $request)
    {
        $request->validate([
            'datum' => 'required|date',
            'tijd' => 'required|string',
        ]);

        $tijd = Tijd::where('moment', $request->tijd)->first();
        $straat = Straat::find($request->straat_id);


        if (!$tijd || !$straat) {
            return back()->with('error', 'Ongeldige tijd of locatie');
        }

        // Max 3 inschrijvingen per moment
        $bestaandAantal = Agenda::where([
            'datum' => $request->datum,
            'tijd_id' => $tijd->id,
            'straat_id' => $straat->id,
        ])->count();

        if ($bestaandAantal >= 3) {
            return back()->with('error', 'Maximum bereikt');
        }

        // Geen dubbele inschrijving
        $alIngeschreven = Agenda::where([
            'datum' => $request->datum,
            'tijd_id' => $tijd->id,
            'straat_id' => $straat->id,
            'user_id' => Auth::id(),
        ])->exists();

        if (!$alIngeschreven) {
            Agenda::create([
                'datum' => $request->datum,
                'tijd_id' => $tijd->id,
                'straat_id' => $straat->id,
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->route('agenda.index', [
    'locatie' => $straat->naam,
    'week' => Carbon::parse($request->datum)->diffInWeeks(now(), false),
]);

    }
// Wissen knop
    public function destroy(Request $request)
    {
       
        $tijd = Tijd::where('moment', $request->tijd)->first();
        $straat = Straat::find($request->straat_id); 
    
        if (!$tijd || !$straat) {
            return back()->with('error', 'Verwijderen mislukt: tijd of straat niet gevonden.');
        }

       Agenda::whereDate('datum', $request->datum)
    ->where('tijd_id', $tijd->id)
    ->where('straat_id', $straat->id)
    ->where('user_id', Auth::id())
    ->delete();
        

    
        return back()->with('success', 'Inschrijving verwijderd.');
    }
}