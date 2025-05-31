<x-layout title="Wachtwoord resetten">
    <div class="bg-gray-800 p-6 rounded-xl shadow-md max-w-md mx-auto">
        <h2 class="text-xl font-semibold text-yellow-300 mb-4">Reset wachtwoord</h2>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block text-sm text-gray-300 mb-2">E-mailadres</label>
                <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required
                       class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600">
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <label for="password" class="block text-sm text-gray-300 mb-2">Nieuw wachtwoord</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600">
                <button type="button" onclick="toggleVisibility('password')" class="absolute right-3 top-9 text-yellow-400">
                    👁️
                </button>
                @error('password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative">
                <label for="password_confirmation" class="block text-sm text-gray-300">Bevestig wachtwoord</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600">
                <button type="button" onclick="toggleVisibility('password_confirmation')" class="absolute right-3 top-9 text-yellow-400">
                    👁️
                </button>
            </div>

            <button type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold py-2 px-4 rounded">
                Reset wachtwoord
            </button>
        </form>
    </div>
</x-layout>

    
