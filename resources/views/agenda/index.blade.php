<x-layout title="Agenda">
    <h1 class="text-4xl mb-4 font-bold text-center mt-20">Vrijwilligers Agenda</h1>
    <p class="pb-3 text-center">Tot 3 pers. per keer | Late avond alleen bij padden weer</p>

    {{-- Locatie filter --}}
    <form method="GET" class="mb-6 text-center">
        <select name="locatie" class="p-2 bg-gray-700 text-white rounded">
            <option value="Merestraat" {{ $locatie === 'Merestraat' ? 'selected' : '' }}>Merestraat</option>
            <option value="Mombeekstraat" {{ $locatie === 'Mombeekstraat' ? 'selected' : '' }}>Mombeekstraat</option>
        </select>
        <button type="submit" class="bg-yellow-600 px-4 py-2 rounded text-white">Filter toepassen</button>
    </form>

    {{-- Week navigatie --}}
    <div class="grid grid-cols-2 gap-4 max-w-md mx-auto mb-6">
        <a href="?week={{ $weekOffset - 1 }}&locatie={{ urlencode($locatie) }}" class="bg-yellow-600 px-4 py-2 rounded-lg text-white text-center">Vorige week</a>
        <a href="?week={{ $weekOffset + 1 }}&locatie={{ urlencode($locatie) }}" class="bg-yellow-600 px-4 py-2 rounded-lg text-white text-center">Volgende week</a>
    </div>

    {{-- Agenda tabel --}}
    <div class="overflow-x-auto w-full max-w-6xl mx-auto mb-20">
        <table class="w-full bg-gray-700 text-white rounded-lg">
            <thead class="bg-gray-600 text-center">
                <tr>
                    <th class="px-4 py-3 text-lg font-extrabold uppercase text-black border
                        {{ $locatie === 'Merestraat' ? 'bg-yellow-100 border-yellow-300' : 'bg-green-500 border-green-700' }}">
                        {{ $locatie }}
                    </th>
                    <th class="px-4 py-2">Ochtend</th>
                    <th class="px-4 py-2">Vroege avond</th>
                    <th class="px-4 py-2">Late avond</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 7; $i++)
                    @php
                        $dagISO = \Carbon\Carbon::parse($startDatum)->addDays($i)->toDateString();
                        $dagDatum = \Carbon\Carbon::parse($dagISO)->translatedFormat('l d-m-Y');
                    @endphp
                    <tr class="border-b hover:bg-gray-600 text-center">
                        <td class="px-4 py-2 font-bold">{{ $dagDatum }}</td>
            
                        @foreach(['ochtend', 'vroege avond', 'late avond'] as $tijdMoment)
                            @php
                                $inschrijvingen = $agendaItems[$dagISO][$tijdMoment] ?? [];
                                $aantal = count($inschrijvingen);
                                $ingeschrevenNamen = implode(', ', $inschrijvingen);
                                $mijnNaam = auth()->check() ? auth()->user()->name : null;
                                $mijnInschrijving = in_array($mijnNaam, $inschrijvingen);
                            @endphp
            
                            <td class="px-4 py-2">
                                <input type="text"
                                    class="w-full text-center text-black {{ $aantal ? 'bg-yellow-100' : 'bg-gray-500' }}"
                                    value="{{ $ingeschrevenNamen ?: '—' }}"
                                    readonly>
                                    @auth


                                        @if ($mijnInschrijving)
                                        <form method="POST" action="{{ route('agenda.destroy') }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="datum" value="{{ $dagISO }}">
                                            <input type="hidden" name="tijd" value="{{ $tijdMoment }}">
                                            <input type="hidden" name="straat_id" value="{{ $straatId }}">
                                            <button type="submit" class="bg-yellow-900 text-white px-2 py-1 rounded">Wissen</button>
                                        </form>
                                        
                                        @elseif ($aantal < 3)
                                        <form method="POST" action="{{ route('agenda.store') }}" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="datum" value="{{ $dagISO }}">
                                        <input type="hidden" name="tijd" value="{{ $tijdMoment }}">
                                        <input type="hidden" name="straat_id" value="{{ $straatId }}">
                                        <button type="submit" class="bg-green-700 text-white px-2 py-1 rounded">Toevoegen</button>
                                        </form>
                                        @endif
                                    @endauth
                                </td>
                        @endforeach
                    </tr>
                @endfor
            </tbody>            
        </table>
    </div>
</x-layout>

