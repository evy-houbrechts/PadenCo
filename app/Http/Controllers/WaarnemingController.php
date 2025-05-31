<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Waarneming;
use App\Models\AantalWaarneming;
use App\Models\Tijd;    
use App\Models\Soort;
use App\Models\Categorie;
use App\Models\Straat;

//pagina's invoer en invoer aanpassen
class WaarnemingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //invoer pagina waarnemingen ophalen
    public function index(Request $request)
    { 
        $user = Auth::user();
        $waarnemingen = collect();
    //door middel van een filter
        if ($request->filled('datum') || $request->filled('tijd_id') || $request->filled('straat_id')) {
        $waarnemingen = Waarneming::with([
                'straat',
                'tijd',
                'aantalWaarnemingen.soort',
                'aantalWaarnemingen.categorie'
            ])
            ->where('user_id', $user->id)
            ->when($request->straat_id, fn($q) => $q->where('straat_id', $request->straat_id))
            ->when($request->tijd_id, fn($q) => $q->where('tijd_id', $request->tijd_id))
            ->when($request->datum, fn($q) => $q->where('datum', $request->datum))
            ->get();
        }
    
        $straten = Straat::all();
        $tijden = Tijd::all();
        $soorten = Soort::all();           
        $categorieen = Categorie::all();  
//totalen berekenen
        $totaalPerSoort = [];
        $slachtoffers = 0;
        $terugkeerders = 0;
        $totaalDieren = 0;

        foreach ($waarnemingen as $entry) {
            foreach ($entry->aantalWaarnemingen as $item) {
                $soortId = $item->soort_id;
                $categorie = strtolower($item->categorie->label);
                $aantal = $item->aantal;

            if (!isset($totaalPerSoort[$soortId])) {
                $totaalPerSoort[$soortId] = 0;
            }

            // koppels tellen dubbel en slachtoffers en terugkerders tellen apart
            if ($categorie === 'koppel') {
                $totaalPerSoort[$soortId] += $aantal * 2;
                $totaalDieren += $aantal * 2;
            } elseif ($categorie === 'slachtoffer') {
                $slachtoffers += $aantal;
            } elseif ($categorie === 'terugkerende') {
                $terugkeerders += $aantal;
            } else {
                $totaalPerSoort[$soortId] += $aantal;
                $totaalDieren += $aantal;
            }
        }
    }

    return view('waarneming.index', compact(
            'waarnemingen', 
            'straten', 
            'tijden', 
            'soorten', 
            'categorieen',
            'totaalPerSoort', 
            'slachtoffers', 
            'terugkeerders', 
            'totaalDieren'
));

    }

    /**
     * Store a newly created resource in storage.
     */
    //opslaan van de invoer
    public function store(Request $request)
    {
        $request->validate([
            'straat_id' => 'required',
            'tijd_id' => 'required',
            'datum' => 'required|date',
        ]);
        // Zoeken of de waarneming al bestaat
        $waarneming = Waarneming::firstOrCreate([
            'user_id' => Auth::id(),
            'datum' => $request->datum,
            'straat_id' => $request->straat_id,
            'tijd_id' => $request->tijd_id,
        ]);
    
        // Aantal-waarnemingen toevoegen
        foreach ($request->input('aantal_waarnemingen', []) as $item) {
            if (isset($item['categorieen'])) {
                foreach ($item['categorieen'] as $cat) {
                    AantalWaarneming::create([
                        'waarneming_id' => $waarneming->id,
                        'soort_id' => $item['soort_id'],
                        'categorie_id' => $cat['categorie_id'],
                        'aantal' => $cat['aantal'],
                    ]);
                }
            }
        }
    //voorlopig opslaan, filter blijft staan en onderaan tabel
        if ($request->has('voorlopig_opslaan')) {
            return redirect()->route('waarneming.index', [
                'datum' => $request->datum,
                'tijd_id' => $request->tijd_id,
                'straat_id' => $request->straat_id,
            ])->with('success', 'Voorlopig opgeslagen. Je kan verder invoeren.');
        }
        return redirect()->route('waarneming.index')->with('success', 'Succesvol opgeslagen.');
    }

     //invoer aanpassen - ophalen van de invoer
     public function create(Request $request)
     {
         $straten = Straat::all();
         $tijden = Tijd::all();
         $soorten = Soort::all();
         $categorieen = Categorie::all();
     
         $waarneming = null;
         $waarnemingen = collect();
         $totaalPerSoort = [];
         $totaalDieren = 0;
         $slachtoffers = 0;
         $terugkeerders = 0;
     
         $isGefilterd = $request->filled('datum') && $request->filled('straat_id') && $request->filled('tijd_id');
     
         if ($isGefilterd) {
             $waarnemingen = Waarneming::where('user_id', Auth::id())
                 ->where('datum', $request->datum)
                 ->where('straat_id', $request->straat_id)
                 ->where('tijd_id', $request->tijd_id)
                 ->with(['aantalWaarnemingen.categorie', 'aantalWaarnemingen.soort', 'straat', 'tijd'])
                 ->get();
     
             if ($waarnemingen->isEmpty()) {
                 session()->flash('error', 'Waarneming niet gevonden.');
             } else {
                 $waarneming = $waarnemingen->first();
     
                 foreach ($waarnemingen as $entry) {
                     foreach ($entry->aantalWaarnemingen as $item) {
                         $soortId = $item->soort_id;
                         $categorie = strtolower($item->categorie->label);
                         $aantal = $item->aantal;
     
                         if (!isset($totaalPerSoort[$soortId])) {
                             $totaalPerSoort[$soortId] = 0;
                         }
     
                         if ($categorie === 'koppel') {
                             $totaalPerSoort[$soortId] += $aantal * 2;
                             $totaalDieren += $aantal * 2;
                         } elseif ($categorie === 'slachtoffer') {
                             $slachtoffers += $aantal;
                         } elseif ($categorie === 'terugkerende') {
                             $terugkeerders += $aantal;
                         } else {
                             $totaalPerSoort[$soortId] += $aantal;
                             $totaalDieren += $aantal;
                         }
                     }
                 }
             }
         }
     
         return view('waarneming.create', compact(
             'waarneming',
             'waarnemingen',
             'soorten',
             'categorieen',
             'straten',
             'tijden',
             'totaalPerSoort',
             'totaalDieren',
             'slachtoffers',
             'terugkeerders',
             'isGefilterd'
         ));
     }
     
        
        //invoer aanpassen - update
        public function update(Request $request)
        {
            $request->validate([
                'datum' => 'required|date',
                'straat_id' => 'required|exists:straten,id',
                'tijd_id' => 'required|exists:tijden,id',
            ]);
    
            $waarneming = Waarneming::where('user_id', Auth::id())
                ->where('datum', $request->datum)
                ->where('straat_id', $request->straat_id)
                ->where('tijd_id', $request->tijd_id)
                ->first();
    
            
    
            $waarneming->aantalWaarnemingen()->delete();
    
            foreach ($request->input('aantal_waarnemingen', []) as $soortId => $item) {
                foreach ($item['categorieen'] ?? [] as $categorieId => $cat) {
                    if ($cat['aantal'] !== null && $cat['aantal'] !== '') {
                        AantalWaarneming::create([
                            'waarneming_id' => $waarneming->id,
                            'soort_id' => $soortId,
                            'categorie_id' => $cat['categorie_id'],
                            'aantal' => $cat['aantal'],
                        ]);
                    }
                }
            }
    
            return redirect()->route('waarneming.create', [
                'datum' => $request->datum,
                'straat_id' => $request->straat_id,
                'tijd_id' => $request->tijd_id,
            ])->with('success', 'Waarneming succesvol bijgewerkt.');
        }

        //destroy - invoer verwijderen
    public function destroy(Waarneming $waarneming)
{
    $waarneming->aantalWaarnemingen()->delete();
    $waarneming->delete();

    return redirect()->route('waarneming.create')->with('success', 'Waarneming verwijderd.');
}

}

