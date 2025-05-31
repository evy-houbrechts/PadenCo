<x-layout title="Account">
    <div class="max-w-4xl mx-auto px-4 py-6">
        <h1 class="text-2xl md:text-3xl font-semibold mb-6">
            Dit is je account, {{ Auth::user()->name }}
        </h1>

        {{-- Agenda --}}
        <div class="mb-10">
            <h2 class="text-xl md:text-2xl   font-semibold mb-4">📆 Mijn Agenda</h2>
            <ul class="space-y-2">
                @forelse($agendaItems as $item)
                    <li>
                        <strong>{{ \Carbon\Carbon::parse($item->datum)->format('d/m/Y')  }}</strong> — {{ $item->tijd->moment }} — {{ $item->straat->naam }}
                    </li>
                @empty
                    <li>Je bent nog niet ingeschreven.</li>
                @endforelse
            </ul>
        </div>

        {{-- Invoer aanpassen --}}
        <div class="mb-10">
            <h2 class="text-xl md:text-2xl  font-semibold mb-4 flex items-center gap-2">
                <svg class="w-7 h-7 rotate-12 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M5 3c1.5 0 3 1 4 2s2 2.5 4 2.5 3.5-1.5 5-2 3 .5 3 2-1.5 2.5-2 3.5c-.5 1-.5 1.5-1 2s-1.5 1.5-2.5 1.5H7c-1 0-1.5-.5-2-1s-1-2-1-3 .5-3 1.5-4.5S3.5 3 5 3z" />
                </svg>
                Mijn invoer aanpassen 
            </h2>
            <p class="mb-4">Heb je een foutje gemaakt?</p>

            <div class="bg-green-800 p-4 rounded-lg shadow-lg flex justify-center items-center text-center">
                <a href="{{ route('waarneming.create') }}" class="text-white text-base md:text-lg flex flex-col md:flex-row items-center gap-2">
                    <span class="text-2xl inline-block transform"><img src="/images/logo/logo pad en co 600x600.jpg" alt="logo pad en co" class="w-12 h-12"></span>
                    <span>Hier kan je foutjes aanpassen</span>
                </a>
            </div>
        </div>
   
 {{-- Waarnemingen --}}
 <h2 class="text-xl md:text-2xl font-semibold mb-4 flex items-center gap-2">✨ Mijn Waarnemingen</h2>

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
<div class="bg-gray-800 p-4 rounded-lg shadow mb-10">
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
                            <td class="p-2 text-center">
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

    <div class="mt-4 text-lx text-gray-300 space-y-1">
        <p>🐸🦎 <strong>Totaal amfibieën:</strong> <span class="text-yellow-400">{{ $totaalDieren }}</span></p>
        <p><span class="inline-block transform rotate-180">🐸</span> <strong>Slachtoffers:</strong> {{ $slachtoffers }}</p>
        <p>🔁<strong>Terugkeerders:</strong> {{ $terugkeerders }}</p>
    </div>
</div>

{{-- Profielgegevens bijwerken --}}
<h2 class="text-xl md:text-2xl font-semibold mb-4">👤 Mijn gegevens bijwerken</h2>
<div class="mt-12 bg-gray-800 p-6 rounded-lg shadow-lg">
    <p class="text-yellow-400 mb-4 ">Je kunt je naam, email of wachtwoord wijzigen hier wijzigen.</p>

    @if (session('profile_updated'))
        <p class="text-green-400 mb-4">{{ session('profile_updated') }}</p>
    @endif

    @if (session('name_change_error'))
        <p class="text-red-400 mb-4">{{ session('name_change_error') }}</p>
    @endif

    <form action="{{ route('account.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm text-gray-300">Naam</label>
            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                   class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-yellow-300">
            @error('name')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm text-gray-300">E-mailadres</label>
            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                   class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600">
            @error('email')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm text-gray-300">Nieuw wachtwoord (optioneel)</label>
            <input type="password" name="password" id="password"
                   class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600">
            @error('password')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm text-gray-300">Bevestig wachtwoord</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600">
        </div>

        <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold py-2 px-4 rounded">
            Wijzigingen opslaan
        </button>
    </form>
</div>
<div class="mt-4 text-right">
    <div class="inline-block">
        <x-logout />
    </div>
</div>



</div>
</x-layout>