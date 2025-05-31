
<x-filament::page>
    <div class="bg-green-800 rounded-lg shadow-lg flex justify-end">
            <span class="text-2xl inline-block transform rotate-12">🦎</span>
            <a href="{{ route('home') }}">
                ➜ Ga terug naar de homepagina</a>
    </div>
   
    @php
        $recentAgendas = \App\Models\Agenda::with(['user', 'straat', 'tijd'])->latest()->take(5)->get();
        $recentWaarnemingen = \App\Models\Waarneming::with(['user', 'straat', 'tijd'])->latest()->take(5)->get();
        $soortData = \App\Models\Soort::withCount('aantalWaarnemingen')->get();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Agenda --}}
        <div class="bg-green-900 text-black dark:text-white p-4 rounded shadow">
            <h2 class="text-lg font-bold mb-10">📅 Laatste Agenda's</h2>
            <ul class="space-y-2 text-sm">
                @foreach($recentAgendas as $item)
                    <li class="border-b border-green-700 pb-1">
                        <strong>{{ \Carbon\Carbon::parse($item->datum)->format('d/m/Y') }}</strong> –
                        {{ $item->tijd->moment ?? '-' }} –
                        {{ $item->straat->naam ?? '-' }}<br>
                        <span class="text-yellow-300">👤 {{ $item->user->name ?? 'onbekend' }}</span>
                    </li>
                @endforeach
            </ul>
            <a href="{{ \App\Filament\Resources\AgendaResource::getUrl() }}"
            class="text-yellow-400 mt-3 inline-block hover:underline">
            ➜ Bekijk alle agenda's
         </a>
        </div>

        {{-- Waarnemingen --}}
        <div class="bg-green-900 text-black dark:text-white p-4 rounded shadow">
            <h2 class="text-lg font-bold mb-6">🐸 Laatste Waarnemingen</h2>
            <ul class="space-y-2 text-sm">
                @foreach($recentWaarnemingen as $item)
                    <li class="border-b border-green-700 pb-1">
                        <strong>{{ \Carbon\Carbon::parse($item->datum)->format('d/m/Y') }}</strong> –
                        {{ $item->tijd->moment ?? '-' }} –
                        {{ $item->straat->naam ?? '-' }}<br>
                        <span class="text-yellow-300">👤 {{ $item->user->name ?? 'onbekend' }}</span>
                    </li>
                @endforeach
            </ul>
            <a href="{{ \App\Filament\Resources\WaarnemingResource::getUrl() }}">
                ➜ Bekijk alle waarnemingen</a>
        </div>
    </div>

    {{-- Grafiek --}}
    <div class="bg-gray-900 p-4 rounded shadow text-black dark:text-white mt-8">
        <h2 class="text-lg font-bold mb-3">📊 Waarnemingen per soort</h2>
        <div style="height: 250px;">
            <canvas id="soortChart"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('soortChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($soortData->pluck('naam')) !!},
                    datasets: [{
                        label: 'Aantal',
                        data: {!! json_encode($soortData->pluck('aantal_waarnemingen_count')) !!},
                        backgroundColor: '#facc15'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        </script>
    </div>
  
</x-filament::page>
