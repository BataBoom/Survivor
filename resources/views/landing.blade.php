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
    <div class="relative h-screen" id="top">
        <div class="bg-black h-full">
            <img src="{{$bg}}" alt="Header Image" class="w-full h-full object-cover opacity-50">
            <div class="absolute inset-0 bg-black bg-opacity-20 flex flex-col justify-center items-center text-white text-center">
                <h1 class="text-3xl lg:text-4xl font-bold mb-4">Outpick, Outplay, Outlast</h1>
                <p class="text-base lg:text-lg mb-8">Welcome to the 3rd Annual NBZ NFL Survivor League.</p>
                <div>
                    <a x-transition.duration.500ms x-on:click.prevent="$scrollTo({ behavior: 'smooth' })" href="#bottom" class="btn btn-primary mr-4">How it works</a>
                    <a href="{{ route('register') }}" wire:navigate class="btn btn-success mr-4">Sign up</a>
                </div>
            </div>
        </div>
    </div>
    <div class="p-8" id="bottom">
        <h1 class="text-center text-2xl text-accent pb-6 tracking-widest">How to play:</h1>

        <div class="flex flex-col lg:grid grid-cols-2 grid-rows-auto place-items-center items-center space-y-4">
            <div class="max-md:hidden row">
                <div class="flex w-full items-center justify-center bg-gray-900">
                    <div class="relative z-0 h-96 w-96 rounded-3xl bg-emerald-500">
                        <img class="w-full" src="https://survivor.nbz.one/images/icons/shape-2.svg" alt="" />
                        <div class="absolute inset-0 z-10 flex items-center justify-center">
                            <img class="object-cover" src="https://i.imgur.com/WQgH3YN.png" alt="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="h-full w-96 rounded-xl bg-green-500 p-6 shadow-lg">
                    <div class="flex flex-col items-center px-6 text-center">
                        <img class="mb-3 h-32 w-32" src="https://survivor.nbz.one/images/icons/goal.png" />
                        <h5 class="mb-1 text-xl font-bold text-white">Think you got what it takes?</h5>
                        <div class="bg-green-900 rounded-xl p-2">
                            <span class="text-sm leading-6 text-white p-2">Training camp in progress! Become the next super star this season! Win big, play for free!</span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="h-full w-96 rounded-xl bg-blue-500 p-6">
                    <div class="flex flex-col items-center px-6 text-center">
                        <img class="mb-3 h-24 w-24" src="https://survivor.nbz.one/images/icons/coach.png" />
                        <div class="bg-blue-900 rounded-xl p-2 shadow-lg">
                            <h5 class="mb-1 text-2xl font-bold text-white">Submit your picks</h5>
                            <span class="text-sm leading-6 text-white">Submit a new team for each week of the NFL Season. Submit picks in advance, or change your pick at the last minute!</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-md:hidden row">
                <div class="flex w-full items-center justify-center bg-gray-900">
                    <div class="relative z-0 h-96 w-96 rounded-3xl bg-blue-500">
                        <img class="w-full" src="https://survivor.nbz.one/images/icons/shape-2.svg" alt="" />
                        <div class="absolute inset-0 z-10 flex items-center justify-center"><<img class="object-cover" src="https://i.imgur.com/2nIuGBI.png" alt="" /></div>
                    </div>
                </div>
            </div>
            <div class="max-md:hidden row">
                <div class="flex w-full items-center justify-center bg-gray-900">
                    <div class="relative z-0 h-96 w-96 rounded-3xl bg-orange-500">
                        <img class="w-full" src="https://survivor.nbz.one/images/icons/shape-2.svg" alt="" />
                        <div class="absolute inset-0 z-10 flex items-center justify-center">
                            <img class="object-cover" src="https://i.imgur.com/WQgH3YN.png" alt="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="h-full w-96 rounded-xl bg-orange-500 p-6">
                    <div class="flex flex-col items-center px-6 text-center">
                        <img class="mb-3 h-32 w-32" src="https://survivor.nbz.one/images/icons/bitcoin.png" />
                        <h5 class="mb-1 text-xl font-bold text-slate-100 underline underline-offset-2">Compete & Earn Bitcoin</h5>
                        <div class="bg-orange-900 rounded-xl p-2 shadow-lg">
                            <span class="text-sm leading-6 text-white font-medium">Win or Tie and Move on! Lose, and die. Last one standing wins 0.01 BTC (FREE TO PLAY)!</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="flex justify-center items-center pt-6">
            <button class="btn btn-primary w-2/3 text-white text-xl tracking-wide">Signup!</button>
        </div>
    </div>
    {{--
    <a x-on:click.prevent="$scrollTo({ behavior: 'smooth' })" href="#top" aria-label="Back to top" class="fixed bottom-0 right-0 p-2 mx-10 my-10 text-white bg-gray-800 hover:bg-gray-700 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
    </a>
    --}}

</x-layouts.landing>
