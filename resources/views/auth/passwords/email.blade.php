<x-layout title="Wachtwoord vergeten">
    <div class="bg-gray-800 p-6 rounded-xl shadow-md max-w-md mx-auto">
        <h2 class="text-xl font-semibold text-yellow-300 mb-4">Wachtwoord vergeten</h2>

        @if (session('status'))
            <p class="text-green-400 text-sm mb-2">{{ session('status') }}<br>
            Check zeker ook je spam</p>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm text-gray-300 mb-2">E-mailadres</label>
                <input type="email" name="email" id="email" required
                       class="w-full px-3 py-2 rounded-md bg-gray-700 text-white border border-gray-600">
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold py-2 px-4 rounded">
                Stuur herstel link
            </button>
        </form>
    </div>
</x-layout>
