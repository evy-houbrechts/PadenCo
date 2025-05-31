<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agenda;
use App\Models\Waarneming;
use App\Models\Straat;
use App\Models\Tijd;
use App\Models\Soort;
use App\Models\Categorie;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{   // account pagina gegevens ophalen
    public function index(Request $request)
    {
        $user = Auth::user();

        // Alle agenda-inschrijvingen van deze gebruiker
        $agendaItems = Agenda::with(['tijd', 'straat'])
            ->where('user_id', Auth::id())
            ->whereDate('datum', '>=', now()->toDateString())
            ->orderBy('datum')
            ->get();
            $straten = Straat::all();
            $tijden = Tijd::all();
            $soorten = Soort::all();
            $categorieen = Categorie::all();

        //alle waarnemingen van deze gebruiker
            $query = Waarneming::with(['aantalWaarnemingen.categorie', 'aantalWaarnemingen.soort', 'straat', 'tijd'])
                        ->where('user_id', $user->id); // 🔑 Alleen eigen waarnemingen
    
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
    
            $matrix = [];
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
    
                    $matrix[$categorieId][$soortId] = ($matrix[$categorieId][$soortId] ?? 0) + $aantal;
    
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
    
            return view('account', compact(
                'soorten',
                'categorieen',
                'straten',
                'tijden',
                'matrix',
                'totaalPerSoort',
                'totaalDieren',
                'slachtoffers',
                'terugkeerders',
                'agendaItems',
                
            ));
        }

        // Update profile
        public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
    ]);
    if ($request->name !== $user->name) {
        $user->name = $request->name;
    }
    if ($request->email !== $user->email) {
        $user->email = $request->email;
    }
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();
    return back()->with('profile_updated', 'Je gegevens zijn succesvol bijgewerkt.');
}
}
