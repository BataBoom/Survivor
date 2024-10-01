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
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

        @livewireStyles
        <!-- Scripts -->
        @vite(['resources/js/wire.js', 'resources/js/app.js'])
        <style>
            .first-item {
                display: block;
                width: 100%;
            }
        </style>
        <x-meta-data/>
    </head>
    <body data-theme="dark" class="font-sans antialiased">
        <div class="min-h-screen">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="container mx-auto">
                {{ $slot }}
            </main>
        </div>

    </body>

    @livewireScriptConfig

    <x-mary-toast />
    <script type="text/javascript">
        /*
var end = Date.now() + (15 * 1000);

// go Buckeyes!
var colors = ['#fbff6c', '#6ce8ff'];

(function frame() {
  confetti({
   particleCount: 2,
    angle: 240,
    spread: 255,
    origin: { y: -0.07, x: 0.3},
    colors: colors
  });
  confetti({
    particleCount: 2,
    angle: 240,
    spread: 255,
    origin: { y: -0.07, x: 0.7},
    colors: colors
  });
  if (Date.now() < end) {
    requestAnimationFrame(frame);
  }
}());

var duration = 15 * 1000;
var animationEnd = Date.now() + duration;
var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

function randomInRange(min, max) {
  return Math.random() * (max - min) + min;
}

var interval = setInterval(function() {
  var timeLeft = animationEnd - Date.now();

  if (timeLeft <= 0) {
    return clearInterval(interval);
  }

  var particleCount = 50 * (timeLeft / duration);
  // since particles fall down, start a bit higher than random
  confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } });
  confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } });
}, 250);
*/

    </script>
</html>
