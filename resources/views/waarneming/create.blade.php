<x-layout title="Waarneming Details">

    <h2 class="text-xl mb-4"><strong>Heb jij een verkeerde invoer gedaan?</strong> Dat kan je hier wissen</h2>

    {{-- Filters --}}
    <form method="GET" action="{{ route('waarneming.create') }}" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="datum" class="block text-white">Datum:</label>
                <input type="date" name="datum" id="datum" 
                value="{{ request('datum') }}" 
                class="w-full p-2 bg-gray-700 text-white rounded @error('datum') border-red-500 @enderror">
            </div>

            <div>
                <label for="straat_id" class="block text-white">Straat:</label>
                <select name="straat_id" id="straat_id"
                    class="w-full p-2 bg-gray-700 text-white rounded @error('straat_id') border-red-500 @enderror">
                    <option value="" disabled {{ request('straat_id') == null ? 'selected' : '' }}>Selecteer een straat</option>
                    @foreach($straten as $straat)
                        <option value="{{ $straat->id }}" {{ request('straat_id') == $straat->id ? 'selected' : '' }}>
                            {{ $straat->naam }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tijd_id" class="block text-white">Tijd:</label>
                <select name="tijd_id" id="tijd_id"
                    class="w-full p-2 bg-gray-700 text-white rounded @error('tijd_id') border-red-500 @enderror">
                    <option value="" disabled {{ request('tijd_id') == null ? 'selected' : '' }}>Selecteer een tijd</option>
                    @foreach($tijden as $tijd)
                        <option value="{{ $tijd->id }}" {{ request('tijd_id') == $tijd->id ? 'selected' : '' }}>
                            {{ $tijd->moment }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-500 text-white px-6 py-2 rounded w-full">
                    Filter
                </button>
            </div>
        </div>
    </form>

    {{-- Als er nog niet gefilterd is, toon instructie --}}
    @if(!$isGefilterd)
    <div class="bg-yellow-500 text-black p-4 rounded shadow mb-6">
        Selecteer eerst een datum, straat en tijd om een waarneming aan te passen.
    </div>
    @endif


    {{-- Feedback --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    {{-- Alleen tonen als gefilterd en waarneming bestaat --}}
    @if($waarneming)
    <form method="POST" action="{{ route('waarneming.update', ['waarneming' => 0]) }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- filters meegeven --}}
        <input type="hidden" name="datum" value="{{ request('datum') }}">
        <input type="hidden" name="straat_id" value="{{ request('straat_id') }}">
        <input type="hidden" name="tijd_id" value="{{ request('tijd_id') }}">

        @foreach($soorten as $soort)
            <div class="p-4 bg-gray-700 rounded-lg">
                <h2 class="text-xl font-bold text-white mb-4">{{ $soort->naam }}</h2>
                <input type="hidden" name="aantal_waarnemingen[{{ $soort->id }}][soort_id]" value="{{ $soort->id }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($categorieen as $categorie)
                        @php
                            $isKoppel = strtolower($categorie->label) === 'koppel';
                            if ($isKoppel && !$soort->kan_koppels) continue;
                            $bestaandAantal = $waarneming->aantalWaarnemingen
                                ->where('soort_id', $soort->id)
                                ->where('categorie_id', $categorie->id)
                                ->sum('aantal');
                        @endphp

                        <div class="flex items-center gap-2">
                            <label class="text-white w-32 capitalize">{{ $categorie->label }}:</label>
                            <input type="hidden"
                                name="aantal_waarnemingen[{{ $soort->id }}][categorieen][{{ $categorie->id }}][categorie_id]"
                                value="{{ $categorie->id }}">
                            <div class="flex items-center gap-2">
                                <input type="number"
                                    name="aantal_waarnemingen[{{ $soort->id }}][categorieen][{{ $categorie->id }}][aantal]"
                                    value="{{ $bestaandAantal }}"
                                    class="w-20 p-2 text-center bg-gray-600 text-white rounded aantal-input">
                                <button type="button"
                                    onclick="increment(this)"
                                    class="bg-green-600 hover:bg-yellow-500 text-white px-2 py-1 rounded">+1</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="text-center">
            <button type="submit" class="bg-yellow-600 hover:bg-yellow-500 text-white px-6 py-2 rounded">
                Aanpassen
            </button>
        </div>
    </form>
    <div class="text-center mt-4">
        <form action="{{ route('waarneming.destroy', ['waarneming' => $waarneming->id]) }}" method="POST"
              onsubmit="return confirm('Weet je zeker dat je deze waarneming wilt verwijderen?')"
              class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-6 py-2 rounded">
                Alles verwijderen
            </button>
        </form>
    </div>
    @endif
    @if($waarneming)
        <div class="mt-10 space-y-6">
            <div class="bg-gray-800 p-4 rounded-lg shadow">
                <div class="text-sm text-gray-300 mb-2 space-x-4">
                    <span><strong>Datum:</strong> {{ $waarneming->datum }}</span>
                    <span><strong>Straat:</strong> {{ $waarneming->straat->naam ?? '-' }}</span>
                    <span><strong>Tijd:</strong> {{ $waarneming->tijd->moment ?? '-' }}</span>
                </div>

                <table class="min-w-full text-white border border-gray-600 mt-2">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="p-2">Categorie \ Soort</th>
                            @foreach($soorten as $soort)
                                <th class="p-2 text-yellow-300 text-center">{{ $soort->naam }}</th>
                            @endforeach

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
                                    <td class="p-2 text-center">{{ $aantal }}</td>
                                @endforeach
                            
                        @endforeach
                        <tr class="bg-gray-800 border-t border-gray-600">
                            <td class="p-2 font-semibold text-green-400">Totaal overgestoken</td>
                            @foreach($soorten as $soort)
                                <td class="p-2 text-center font-bold text-green-400">{{ $totaalPerSoort[$soort->id] ?? 0 }}</td>
                            @endforeach
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-800 font-bold">
                            <td colspan="{{ count($soorten) }}" class="text-left p-2">
                                Totaal amfibieën: <span class="text-yellow-400">{{ $totaalDieren }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-4 text-sm text-gray-300 space-y-1">
                    <p>🐸 <strong>Slachtoffers:</strong> {{ $slachtoffers }}</p>
                    <p>🔁 <strong>Terugkeerders:</strong> {{ $terugkeerders }}</p>
                </div>
            </div>
        </div>
    @endif


    <script>
        function increment(button) {
            const input = button.closest('.flex').querySelector('input');
            input.value = parseInt(input.value || 0) + 1;
        }
    </script>

</x-layout>
