<header class="bg-green-900 text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center">
            <a href="{{ route('home') }}"><img src="{{ asset('images/logo/logo pad en co 1500x600.jpg') }}"
                alt="logo pad&co"
                class="h-14 sm:h-14 md:h-16 lg:h-20 w-auto">
            </a>
        </div>
        <div x-data="{ open: false }" class="lg:flex lg:items-center">
            {{-- Hamburger Button (alleen mobiel) --}}
            <button @click="open = !open" class="lg:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>
        
            {{-- Menu --}}
            <nav 
                id="main-menu" 
                :class="{'flex': open, 'hidden': !open}" 
                class="flex-col lg:flex lg:flex-row lg:items-center lg:space-x-4 mt-4 lg:mt-0 space-y-2 lg:space-y-0 hidden lg:flex"
            >

            @if (auth()->check() && auth()->user()->is_admin)
            <a href="{{ url('/admin') }}" class="hover:text-yellow-300">Dashboard</a>
        @endif
        
          
            <div class="relative group inline-block">
                <span class="hover:text-yellow-300 cursor-pointer block">Pad&Co</span>
                <div class="absolute top-full left-0 hidden group-hover:flex hover:flex flex-col bg-green-950 rounded shadow-lg z-50 w-32 text-white">
                    <a href="{{ route('vrijwilliger.index') }}" class="px-4 py-2 hover:bg-green-800">Vrijwilligers</a>
                    <a href="{{ route('vrijwilliger.form') }}" class="px-4 py-2 hover:bg-green-800">Help je mee?</a>
                    <a href="{{ route('vrijwilliger.soorten') }}" class="px-4 py-2 hover:bg-green-800">Soorten</a>
                </div>
            </div>
            <a href="{{ route('agenda.index') }}" class="hover:text-yellow-300">Agenda</a>
            <a href="{{ route('uitslagen') }}" class="hover:text-yellow-300">Uitslagen</a>
            @auth
            <a href="{{ route('waarneming.index') }}" class="hover:text-yellow-300">Invoer</a>
            <div class="relative group inline-block">
                <span class="text-yellow-300">Hallo, {{ Auth::user()->name }}</span>
                <div class="absolute top-full left-0 hidden group-hover:flex hover:flex flex-col bg-green-950 rounded shadow-lg z-50 w-32 text-white">
                    <a href="{{ route('account') }}" class="px-4 py-2 hover:bg-green-800">
                        Account
                    </a>
                    <x-logout />
                </div>
            </div>
            @else
                <a href="{{ route('login') }}" class="hover:text-yellow-300">Login</a>
                <a href="{{ route('register') }}" class="hover:text-yellow-300">Registreer</a>
            @endauth
            </nav>
            </div>

   <!-- Icoontjes voor het schakelen van de modus -->
<div class="flex items-center space-x-2 mt-2">
    <!-- Zon-icoon voor dagmodus -->
    <button id="toggle-dark-mode" class="text-yellow-400">☀️
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
        </svg>
    </button>

    <!-- Maan-icoon voor nachtmodus -->
    <button id="toggle-dark-mode-moon" class="text-yellow-400 hidden">🌙
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            
        </svg>
    </button>
</div>

</header>

