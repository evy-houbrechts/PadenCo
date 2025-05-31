<x-layout title="Waarnemingen">
    <form action="{{ route('waarneming.store') }}" method="POST" class="space-y-6 mt-6">
        @csrf
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif
    
        {{-- Algemene gegevens --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-yellow-600 p-4 rounded-lg">
            <div>
                <label for="datum" class="block text-white">Datum:</label>
                <input type="date" name="datum" id="datum" value="{{ request('datum', old('datum')) }}" class="w-full p-2 bg-gray-700 text-white rounded">
                @error('datum')
                    <p class="mb-2 p-2 bg-red-700 text-white rounded">Datum selecteren</p>
                @enderror
            </div>
    
            
            <div>
                <label for="straat_id" class="block text-white">Straat:</label>
                <select name="straat_id" id="straat_id" class="w-full p-2 bg-gray-700 text-white rounded">
                    <option value="" disabled {{ (request('straat_id') == null && old('straat_id') == null) ? 'selected' : '' }}>
                        Selecteer een straat
                    </option>
                    @foreach($straten as $straat)
                     <option value="{{ $straat->id }}" 
                        {{ (request('straat_id') == $straat->id || old('straat_id') == $straat->id) ? 'selected' : '' }}>
                        {{ $straat->naam }}
                    </option>
                    @endforeach    
                </select>
                @error('straat_id')
                    <p class="mb-2 p-2 bg-red-700 text-white rounded">Straat selecteren</p>
                @enderror
            </div>
    
            <div>
                <label for="tijd_id" class="block text-white">Tijd:</label>
                <select name="tijd_id" id="tijd_id" class="w-full p-2 bg-gray-700 text-white rounded">
                    <option value="" disabled {{ (request('tijd_id') == null && old('tijd_id') == null) ? 'selected' : '' }}>
                        Selecteer een moment
                    </option>
                    @foreach($tijden as $tijd)
                    <option value="{{ $tijd->id }}" 
                        {{ (request('tijd_id') == $tijd->id || old('tijd_id') == $tijd->id) ? 'selected' : '' }}>
                        {{ $tijd->moment }}
                    </option>
                    @endforeach
                </select>
                @error('tijd_id')
                    <p class="mb-2 p-2 bg-red-700 text-white rounded">Tijd selecteren</p>
                @enderror
            </div>
        </div>
        
        {{-- Soorten en categorieën --}}
        @foreach($soorten as $soort)
            <div class="p-4 bg-gray-700 rounded-lg">
                <h2 class="text-xl font-bold text-white mb-4">{{ $soort->naam }}</h2>
                <input type="hidden" name="aantal_waarnemingen[{{ $loop->index }}][soort_id]" value="{{ $soort->id }}">
    
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    @foreach($categorieen as $categorie)
                    @php
                        $isKoppel = strtolower($categorie->label) === 'koppel';
                    @endphp
                    @if($isKoppel && !$soort->kan_koppels)@continue @endif
                    <div class="flex items-center gap-2">
                            <label class="text-white w-32 capitalize">{{ $categorie->label }}:</label>
                            <input type="hidden" name="aantal_waarnemingen[{{ $loop->parent->index }}][categorieen][{{ $loop->index }}][categorie_id]" 
                            value="{{ $categorie->id }}">
                            <div class="flex items-center gap-2">
                                <input type="number" name="aantal_waarnemingen[{{ $loop->parent->index }}][categorieen][{{ $loop->index }}][aantal]"
                                       value="{{ old("aantal_waarnemingen.{$loop->parent->index}.categorieen.{$loop->index}.aantal", 0) }}"
                                       class="w-20 p-2 text-xl text-center bg-gray-600 text-white rounded aantal-input">
                                <button type="button"
                                        onclick="increment(this)"
                                        class="bg-yellow-600 hover:bg-yellow-500 text-white px-2 py-1 rounded text-lg">
                                    +1
                                </button>
                            </div>
                            
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        {{-- Knoppen --}}
        <div class="text-center space-y-4 mt-6">
            <button type="submit" name="voorlopig_opslaan"
                    class="bg-yellow-600 hover:bg-yellow-500 text-white px-6 py-2 rounded">
                Voorlopig Opslaan
            </button>
        
            <button type="submit" name="volledig_opslaan"
                    class="bg-green-600 hover:bg-green-500 text-white px-6 py-2 rounded">
                Volledig Opslaan
            </button>
        </div>   
    </form>

    @if($waarnemingen->isEmpty())
    <p class="text-white text-center mt-6">Er zijn nog geen waarnemingen gevonden voor deze filters.</p>
    @else
    <div class="mt-10 space-y-6">
        @foreach($waarnemingen as $waarneming)
            <div class="bg-gray-800 p-4 rounded-lg shadow">
                <div class="flex justify-between flex-wrap text-sm text-gray-300 mb-2">
                    <span><strong>Datum:</strong> {{ $waarneming->datum }}</span>
                    <span><strong>Straat:</strong> {{ $waarneming->straat->naam ?? '-' }}</span>
                    <span><strong>Tijd:</strong> {{ $waarneming->tijd->moment ?? '-' }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-white border border-gray-600 mt-2">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="p-2">Amfibieën</th>
                            @foreach($soorten as $soort)
                                <th class="p-2 text-yellow-300 text-center">{{ $soort->naam }}</th>
                            @endforeach
                        
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categorieen as $categorie)
                            <tr>
                                <td class="p-2 text-yellow-200">{{ $categorie->label }}</td>
                                @foreach($soorten as $soort)
                                    @php
                                        $aantal = $waarneming->aantalWaarnemingen
                                            ->where('soort_id', $soort->id)
                                            ->where('categorie_id', $categorie->id)
                                            ->sum('aantal');
                                    @endphp
                                    <td class="p-2 text-center text-lg">{{ $aantal }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                
                        {{-- Totaal per soort onderaan --}}
                        <tr class="bg-gray-800 border-t border-gray-600">
                            <td class="p-2 font-semibold text-green-500">Totaal overgestoken</td>
                            @foreach($soorten as $soort)
                            @php
                            $kolomTotaal = $waarneming->aantalWaarnemingen
                                ->where('soort_id', $soort->id)
                                ->filter(fn($item) => in_array(strtolower($item->categorie->label), ['man', 'vrouw', 'koppel', 'onbekend']))
                                ->sum(function ($item) {
                                    return strtolower($item->categorie->label) === 'koppel' ? $item->aantal * 2 : $item->aantal;
                                });
                        @endphp
                                <td class="p-2 text-center text-lg font-bold text-green-500">{{ $kolomTotaal }}</td>
                            @endforeach
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-4 text-lg text-gray-300 space-y-1">
                    <p>🐸🦎 <strong>Totaal amfibieën:</strong> <span class="text-yellow-400">{{ $totaalDieren }}</span></p>
                    <p><span class="inline-block transform rotate-180">🐸</span> <strong>Slachtoffers:</strong> {{ $slachtoffers }}</p>
                    <p>🔁<strong>Terugkeerders:</strong> {{ $terugkeerders }}</p>
                </div>
            </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
    
</x-layout>    

<script>
    function increment(button) {
        const input = button.closest('.flex').querySelector('input');
        input.value = parseInt(input.value || 0) + 1;
    }
</script>
