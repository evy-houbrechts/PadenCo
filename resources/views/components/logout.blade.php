<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="px-4 py-2 hover:bg-green-800">Logout</button>
</form>