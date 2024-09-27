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
    <x-meta-data/>
    <!-- Scripts -->

    @vite(['resources/js/wire.js', 'resources/js/app.js'])
   
    <style>
        .first-item {
            display: block;
            width: 100%;
        }
         html {
             scroll-behavior: smooth;
         }
         .timer{
            display:flex;
        }
        .timer h1 + h1:before{
          content:":"
        }
    </style>
 <script type="text/javascript">
function timer(expiry) {
  return {
    expiry: expiry,
    remaining:null,
    init() {
      this.setRemaining()
      setInterval(() => {
        this.setRemaining();
      }, 1000);
    },
    setRemaining() {
      const diff = this.expiry - new Date().getTime();
      this.remaining =  parseInt(diff / 1000);
    },
    days() {
      return {
        value:this.remaining / 86400,
        remaining:this.remaining % 86400
      };
    },
    hours() {
      return {
        value:this.days().remaining / 3600,
        remaining:this.days().remaining % 3600
      };
    },
    minutes() {
        return {
        value:this.hours().remaining / 60,
        remaining:this.hours().remaining % 60
      };
    },
    seconds() {
        return {
        value:this.minutes().remaining,
      };
    },
    format(value) {
      return ("0" + parseInt(value)).slice(-2)
    },
    time(){
        return {
        days:this.format(this.days().value),
        hours:this.format(this.hours().value),
        minutes:this.format(this.minutes().value),
        seconds:this.format(this.seconds().value),
      }
    },
  }
}

    </script>

</head>
<body data-theme="dark" class="dark font-sans antialiased">
<div class="min-h-screen">

    <livewire:layout.navigation />


    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

</div>


@stack('scripts')
<x-mary-toast />

</body>
</html>