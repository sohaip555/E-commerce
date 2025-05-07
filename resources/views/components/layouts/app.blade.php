<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{$title ?? config('app.name')}}
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>
<body class="font-sans antialiased bg-slate-200 dark:bg-slate-700 dark:text-white">
@livewire('partials.navbar')
    <main >
        {{ $slot }}
    </main>
@livewire('partials.footer')
     @livewireScripts
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
