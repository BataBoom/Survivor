<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-left p-2 text-xl"> Hello, {{ ucwords(Auth::user()->name) }}</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2 mx-4">


                <div class="bg-white transition text-green-500 hover:text-black hover:bg-green-500  rounded-lg shadow-md p-6">
                    <a href="{{ route('mypools.show') }}">
                        <h2 class="text-xl font-bold mb-4">Browse Pools</h2>
                        <p class="text-black font-semibold">
                            Show me the latest and greatest pools for the upcoming season.
                        </p>
                    </a>
                </div>

                <div class="bg-white transition text-purple-500 hover:text-white hover:bg-green-500  rounded-lg shadow-md p-6">
                    <a href="{{ route('pool.create') }}">
                        <h2 class="text-xl font-bold mb-4">Create Pool

                        </h2>
                        <p class="text-black font-semibold">
                            Host your own pick'em or survivor pool(s) for the 2024-2025 season.
                        </p>
                    </a>
                </div>

                <div class="bg-white transition text-blue-500 hover:text-white hover:bg-indigo-500  rounded-lg shadow-md p-6">
                    <a href="{{ route('faq.index') }}">
                        <h2 class="text-xl font-bold mb-4">Frequently Asked Questions</h2>
                        <p class="text-black font-semibold">
                            Get in the game & Explore our frequently asked questions</p>
                    </a>
                </div>

                <div class="bg-white transition text-purple-500 hover:text-white hover:bg-indigo-500  rounded-lg shadow-md p-6">
                    <a href="{{ route('trophies.index') }}">
                        <h2 class="text-xl font-bold mb-4">Trophy Room</h2>
                        <p class="text-black">View Survivor Legends</p>
                    </a>
                </div>

                <div class="bg-white transition text-accent hover:text-white hover:bg-orange-500  rounded-lg shadow-md p-6">
                    <a href="{{ route('mypools.show') }}">
                        <h2 class="text-xl font-bold mb-4">Quick Stats</h2>
                        <p class="text-black hover:text-white font-semibold">Alive: 69 | Dead: 4
                        </p>
                    </a>
                </div>

                <div class="bg-white transition text-primary hover:text-accent hover:bg-blue-800  rounded-lg shadow-md p-6">
                    <a href="http://telegram.me/satoshyeez_bot" target="_blank">
                        <h2 class="text-xl font-bold mb-4">Telegram</h2>
                        <p class="underline">Add us on the gram</p>
                    </a>
                </div>

                <div class="bg-white transition text-primary hover:text-accent hover:bg-blue-800  rounded-lg shadow-md p-6">
                    <a href="{{ route('support.index') }}" target="_blank">
                        <h2 class="text-xl font-bold mb-4">Contact Support</h2>
                    </a>
                </div>

                <div class="bg-white transition text-purple-500 hover:text-white hover:bg-indigo-500  rounded-lg shadow-md p-6">
                    <a href="{{ route('my-payments.index') }}">
                        <h2 class="text-xl font-bold mb-4">My Payments</h2>
                        <p class="text-black">View my payment ledger</p>
                    </a>
                </div>
            </div>
    </div>
</x-app-layout>
