<x-layouts.landing>
<x-slot name="title">
NFL Survivor
</x-slot>
{{--
<div class="container mx-auto p-4">
    <div class="grid grid-cols-1 lg:grid-cols-6 gap-4">
        <!-- Left Column -->
        <div class="hidden lg:block lg:col-span-1 bg-gray-200 p-4">
            <img src="https://i.imgur.com/2nIuGBI.png">
        </div>
        <!-- Middle Column -->
        <div class="col-span-1 lg:col-span-4 bg-gray-300 p-4">
            Middle Column
        </div>
        <!-- Right Column -->
        <div class="hidden lg:block lg:col-span-1 bg-gray-200 p-4">
            <img src="https://img.freepik.com/free-psd/american-football-ball-isolated_23-2151019473.jpg">
        </div>
    </div>
</div>
--}}

<div class="relative h-screen" id="top" x-data="{
    scrollToBottom() {
    document.querySelector('#bottom').scrollIntoView({ behavior: 'smooth' });
    }
    }">
    <div class="w-full h-full">
        <x-mary-carousel
        :slides="$slides"
        class="h-screen rounded-none">
        @scope('content', $slide)
        <div class="absolute inset-0 flex flex-col justify-center items-center text-white text-center">
            <h1 class="text-3xl lg:text-4xl font-bold mb-4 text-accent  [text-shadow:_0_1px_1px_rgb(0_0_0_/_90%)]">{{ $slide['title'] }}</h1>
            <p class="text-base lg:text-lg mb-8">Welcome to the 3rd Annual NBZ NFL Survivor League.</p>
            <div>
                <a x-transition.duration.500ms x-on:click.prevent="scrollToBottom" href="#bottom" class="btn btn-primary mr-4">How it works</a>
                @guest
                <a href="{{ route('register') }}" wire:navigate class="btn btn-success mr-4">Sign up</a>
                @endguest
                @auth
                <a href="{{ route('dashboard') }}" wire:navigate class="btn btn-success mr-4">Dashboard</a>
                @endauth
            </div>
        </div>
        @endscope
        </x-mary-carousel>
    </div>
</div>
</div>
<div class="p-8" id="bottom">
<section class="bg-white dark:bg-gray-900">
    <div class="mx-auto max-w-screen-xl items-center gap-8 px-4 py-8 lg:grid lg:grid-cols-2 lg:px-6 lg:py-16 xl:gap-16">
        <div class="text-gray-500 sm:text-lg">
            <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white md:text-4xl">Countdown to Kickoff </h2>
            <div class="timer mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white md:text-4xl" x-data="timer(new Date('2024-09-05T23:00:00').getTime())" x-init="init();">
                <h1 x-text="time().days"></h1><p class="text-sm m-2">Days</p>
                <h1 x-text="time().hours"></h1><p class="text-sm m-2">Hours</p>
                <h1 x-text="time().minutes"></h1><p class="text-sm m-2">Mins</p>
                <h1 x-text="time().seconds"></h1><p class="text-sm m-2">Seconds</p>
            </div>
            <p class="mb-8 font-light dark:text-gray-400 lg:text-xl">Training camp in progress! Become the next super star this season!</p>
            <div class="grid gap-6 dark:border-gray-700 sm:grid-cols-2 lg:grid-cols-1 mb-8">
                <div class="flex">
                    <div class="mr-4 shrink-0">
                        <li class="flex items-center text-blue-600 dark:text-blue-500">
                            <span class="me-2 flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-blue-600 text-xs dark:border-blue-500"> 1 </span>
                        </li>
                    </div>
                    <div>
                        <p class="mb-1 text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Win Big, Play For Free</p>
                        <p class="font-light text-gray-500 dark:text-gray-400">Signup now and get drafted into the NBZ Alpha Pool for a chance to win 0.01 BTC ($600~).</p>
                    </div>
                </div>
                <div class="flex">
                    <div class="mr-4 shrink-0">
                        <li class="flex items-center text-blue-600 dark:text-blue-500">
                            <span class="me-2 flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-blue-600 text-xs dark:border-blue-500"> 2 </span>
                        </li>
                    </div>
                    <div>
                        <p class="mb-1 text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Compete</p>
                        <p class="font-light text-gray-500 dark:text-gray-400">Submit a new team for each week of the NFL Season. Submit picks in advance, or change your pick at the last minute!</p>
                    </div>
                </div>
                <div class="flex">
                    <div class="mr-4 shrink-0">
                        <li class="flex items-center text-blue-600 dark:text-blue-500">
                            <span class="me-2 flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-blue-600 text-xs dark:border-blue-500"> 2 </span>
                        </li>
                    </div>
                    <div>
                        <p class="mb-1 text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Outpick & Survive</p>
                        <p class="font-light text-gray-500 dark:text-gray-400">Win or Tie and Move on! One loss and you're out!</p>
                    </div>
                </div>
                <div class="flex">
                    <div class="mr-4 shrink-0">
                        <li class="flex items-center text-blue-600 dark:text-blue-500">
                            <span class="me-2 flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-blue-600 text-xs dark:border-blue-500"> TIP </span>
                        </li>
                    </div>
                    <div>
                        <p class="mb-1 text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Increase Odds</p>
                        <p class="font-light text-gray-500 dark:text-gray-400">Create and/or Join as many pools as you'd like prior to the season</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Illustration -->
        <div class="mx-auto mb-4 sm:pt-8">
            <a href="{{ route('register') }}" wire:navigate class="btn btn-primary w-full mb-4">Click Here To Signup</a>
            <div class="flex w-full items-center justify-center bg-gray-900">
                <div class="relative z-0 h-96 w-96 rounded-3xl bg-emerald-500">
                    <img class="w-full" src="{{ asset('icons/shape-2.svg') }}" alt="" />
                    <div class="absolute inset-0 z-10 flex items-center justify-center">
                        <img class="object-cover" src="https://i.imgur.com/WQgH3YN.png" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</x-layouts.landing>
