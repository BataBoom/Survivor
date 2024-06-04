<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->

    @vite(['resources/js/wire.js', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .first-item {
            display: block;
            width: 100%;
        }
         html {
             scroll-behavior: smooth;
         }
    </style>

</head>
<body class="dark font-sans antialiased">
<div class="min-h-screen">

    <livewire:layout.navigation />


    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

</div>
@livewireScriptConfig

@stack('scripts')
<x-mary-toast />

</body>
</html>