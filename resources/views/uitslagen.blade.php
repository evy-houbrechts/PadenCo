<x-layout title="Uitslagen">
    <h1 class="text-2xl text-yellow-300 font-semibold mb-4">Algemene Uitslagen</h1>

    {{-- Filter formulier --}}
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-yellow-600 p-4 rounded-lg mb-6">
        <div>
            <label for="datum" class="block text-white">Datum:</label>
            <input type="date" name="datum" id="datum" value="{{ request('datum') }}" class="w-full p-2 bg-gray-700 text-white rounded">
        </div>

        <div>
            <label for="straat_id" class="block text-white">Straat:</label>
            <select name="straat_id" id="straat_id" class="w-full p-2 bg-gray-700 text-white rounded">
                <option value="">Alle straten</option>
                @foreach($straten as $straat)
                    <option value="{{ $straat->id }}" {{ request('straat_id') == $straat->id ? 'selected' : '' }}>
                        {{ $straat->naam }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="tijd_id" class="block text-white">Tijd:</label>
            <select name="tijd_id" id="tijd_id" class="w-full p-2 bg-gray-700 text-white rounded">
                <option value="">Alle momenten</option>
                @foreach($tijden as $tijd)
                    <option value="{{ $tijd->id }}" {{ request('tijd_id') == $tijd->id ? 'selected' : '' }}>
                        {{ $tijd->moment }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="md:col-span-3 text-right">
            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-700">Filter toepassen</button>
        </div>
    </form>
   


    {{-- Resultatentabel --}}
    <div class="bg-gray-800 p-4 rounded-lg shadow">
        <h2 class="text-lg text-yellow-300 font-bold mb-4">Samenvattende Tabel</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-white border border-gray-600">
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
                                <td class="p-2 text-center text-lg">
                                    {{ $matrix[$categorie->id][$soort->id] ?? 0 }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr class="bg-gray-800 border-t border-gray-600">
                        <td class="p-2 font-semibold text-green-500">Totaal overgestoken</td>
                        @foreach($soorten as $soort)
                            <td class="p-2 text-lg text-center font-bold text-green-500">
                                {{ $totaalPerSoort[$soort->id] ?? 0 }}
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-lg text-gray-300 space-y-1">
            <p>🐸🦎 <strong>Totaal amfibieën:</strong> <span class="text-yellow-400">{{ $totaalDieren }}</span></p>
            <p><span class="inline-block transform rotate-180">🐸</span> <strong>Slachtoffers:</strong> {{ $slachtoffers }}</p>
            <p>🔁<strong>Terugkeerders:</strong> {{ $terugkeerders }}</p>
        </div>
        
    </div>

</x-layout>

