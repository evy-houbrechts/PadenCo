<x-layout title="Login">
    <div class="bg-gray-800 p-6 rounded-xl shadow-md max-w-md mx-auto">
        <h2 class="text-xl font-semibold text-yellow-300 mb-4">Login</h2>

        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm text-gray-300 mb-2">E-mailadres</label>
                <input type="email" name="email" id="email" required autofocus
                       class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring focus:ring-yellow-300">
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <label for="password" class="block text-sm text-gray-300 mb-2">Wachtwoord</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring focus:ring-yellow-300">
                <button type="button" onclick="toggleVisibility('password')" class="absolute right-3 top-9 text-yellow-400">
                    👁️
                </button>
                @error('password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold py-2 px-4 rounded">
                Inloggen
            </button>
        </form>
        <p class="text-sm text-gray-300 mt-4">Wachtwoord vergeten? <a href="{{ route('password.request') }}" class="text-yellow-300 hover:underline">Klik hier</a></p>
    </div>
</x-layout>



