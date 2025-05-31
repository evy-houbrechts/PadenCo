<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waarneming;
use App\Models\Straat;
use App\Models\Tijd;
use App\Models\Soort;
use App\Models\Categorie;

class UitslagenController extends Controller
{
    //ophalen van alle waarnemingen
    public function index(Request $request)
    { //door middel van filter
        $straten = Straat::all();
        $tijden = Tijd::all();
        $soorten = Soort::all();
        $categorieen = Categorie::all();

        $query = Waarneming::with(['aantalWaarnemingen.categorie', 'aantalWaarnemingen.soort', 'straat', 'tijd']);

        if ($request->filled('datum')) {
            $query->where('datum', $request->input('datum'));
        }

        if ($request->filled('straat_id')) {
            $query->where('straat_id', $request->input('straat_id'));
        }

        if ($request->filled('tijd_id')) {
            $query->where('tijd_id', $request->input('tijd_id'));
        }

        $waarnemingen = $query->get();


    // Totalen
    $matrix = []; // [categorie_id][soort_id] => totaal
    $totaalPerSoort = [];
    $totaalDieren = 0;
    $slachtoffers = 0;
    $terugkeerders = 0;

    foreach ($waarnemingen as $waarneming) {
        foreach ($waarneming->aantalWaarnemingen as $item) {
            $soortId = $item->soort_id;
            $categorieId = $item->categorie_id;
            $categorieLabel = strtolower($item->categorie->label);
            $aantal = $item->aantal;

            // Matrix vullen
            $matrix[$categorieId][$soortId] = ($matrix[$categorieId][$soortId] ?? 0) + $aantal;

            // Totale dieren
            if ($categorieLabel === 'koppel') {
                $totaalDieren += $aantal * 2;
                $totaalPerSoort[$soortId] = ($totaalPerSoort[$soortId] ?? 0) + ($aantal * 2);
            } elseif ($categorieLabel === 'slachtoffer') {
                $slachtoffers += $aantal;
            } elseif ($categorieLabel === 'terugkerende') {
                $terugkeerders += $aantal;
            } else {
                $totaalDieren += $aantal;
                $totaalPerSoort[$soortId] = ($totaalPerSoort[$soortId] ?? 0) + $aantal;
            }
        }
    }
    //controleren of er waarmeningen zijn 
    $isGefilterd = $request->filled('datum') || $request->filled('straat_id') || $request->filled('tijd_id');
    if ($isGefilterd && $waarnemingen->isEmpty()) {
        session()->flash('error', 'Geen resultaten gevonden.');
    }
    

    return view('uitslagen', compact(
        'soorten',
        'categorieen',
        'straten',
        'tijden',
        'matrix',
        'totaalPerSoort',
        'totaalDieren',
        'slachtoffers',
        'terugkeerders'
    ))->with('isGefilterd', $isGefilterd);
}
}

