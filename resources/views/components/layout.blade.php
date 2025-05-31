<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Paddenportaal' }}</title>
    <script src="/js/darkmode-init.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="/css/modus.css">
    <link rel="stylesheet" href="/css/vrijwilligers.css">
    <script src="/js/oogje.js"></script>
</head>

<body class="min-h-screen flex flex-col">
    <x-header />

    <main class="flex-grow">
        <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </div>
    </main>

    <x-footer />

    <script src="/js/darkmode-toggle.js"></script>
</body>
</html>
