<div>
    <div x-data="{ selectedSurvivorId: null, selectedPickemId: null, survivormenu: false, pickemmenu: false }">
        {{--
        <div class="flex justify-center">

        <button
                class="btn btn-sm btn-primary m-2"
                @click="survivormenu = !survivormenu, pickemmenu = false">
           Toggle Survivor Pools
        </button>
            <button
                    class="btn btn-sm bg-red-500 m-2"
                    @click="pickemmenu = !pickemmenu, survivormenu = false">
                Toggle Pickem Pools
            </button>
        </div>
        <div x-show="pickemmenu">
            @forelse($myPickemPools as $pickemPool)
                <div class="flex justify-center">
                    <div class="flex justify-between">
                        <div>
                            <a class="btn btn-sm bg-red-600 m-2" href="{{ route('fun.wire', ['pool' => $pickemPool->pool->id, 'survivorregistration' => $pickemPool->id]) }}" wire:navigate>
                                Go to {{$pickemPool->pool->name}}
                            </a>
                        </div>
                        <div>
                            <button
                                    class="btn btn-sm bg-red-600 m-2"
                                    @click="selectedPickemId = selectedPickemId === '{{ $pickemPool->id }}' ? null : '{{ $pickemPool->id }}'">
                                Toggle {{$pickemPool->pool->name}}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box p-2" x-show="selectedPickemId === '{{ $pickemPool->id }}'">
                    <ul class="flex flex-col text-center">
                        <li>Pool: {{$pickemPool->pool->name}}</li>
                        <li>Max Lives: {{$pickemPool->pool->lives_per_person}}</li>
                        <li>Status: @if($pickemPool->alive) <span class="text-success"> Alive</span> @else <span class="text-error">Dead</span>@endif</li>
                        <li>My Lives: {{$pickemPool->lives_count}}</li>
                        <li>Prize: {{$pickemPool->pool->prize_type}}</li>
                        <li>Starting Contestants: {{ $pickemPool->pool->users->count() }}</li>
                        <li>Remaining Contestants: {{ $pickemPool->pool->survivors->count() }}</li>
                    </ul>
                </div>

            @empty
                <p>No pickem pools found.</p>
            @endforelse
        </div>
        <div x-show="survivormenu">
        @forelse($mySurvivorPools as $survivorPool)
            <div class="flex justify-center">
                <div class="flex justify-between">
                    <div>
                    <a class="btn btn-sm btn-primary m-2" href="{{ route('fun.wire', ['pool' => $survivorPool->pool->id, 'survivorregistration' => $survivorPool->id]) }}" wire:navigate>
                        Go to {{$survivorPool->pool->name}}
                    </a>
                    </div>
                    <div>
                <button
                        class="btn btn-sm btn-primary m-2"
                        @click="selectedSurvivorId = selectedSurvivorId === '{{ $survivorPool->id }}' ? null : '{{ $survivorPool->id }}'">
                    Toggle {{$survivorPool->pool->name}}
                </button>
                    </div>
                </div>
            </div>
                <div class="box p-2" x-show="selectedSurvivorId === '{{ $survivorPool->id }}'">
                    <ul class="flex flex-col text-center">
                        <li>Pool: {{$survivorPool->pool->name}}</li>
                        <li>Max Lives: {{$survivorPool->pool->lives_per_person}}</li>
                        <li>Status: @if($survivorPool->alive) <span class="text-success"> Alive</span> @else <span class="text-error">Dead</span>@endif</li>
                        <li>My Lives: {{$survivorPool->lives_count}}</li>
                        <li>Prize: {{$survivorPool->pool->prize_type}}</li>
                        <li>Starting Contestants: {{ $survivorPool->pool->users->count() }}</li>
                        <li>Remaining Contestants: {{ $survivorPool->pool->survivors->count() }}</li>
                        <li>
                            <a href="{{ route('fun.wire', ['pool' => $survivorPool->pool->id, 'survivorregistration' => $survivorPool->id]) }}" wire:navigate>
                                Go to Survivor Game
                            </a>
                        </li>
                    </ul>
                </div>

        @empty
            <p>No survivor pools found.</p>
        @endforelse
        </div>

        --}}

        <div class="container max-w-7xl sm:mx-6 md:mx-6 lg:mx-auto mt-16 mb-10">
            <div id="body" class="container mx-auto bg-gradient-to-bl from-red-800 via-violet-800 to-blue-500 rounded-3xl">
                <div class="bg-neutral-800 text-white text-lg items-center rounded-t-xl p-4 mb-2">
                    <div class="flex justify-between items-center">
                        <div class="flex justify-start mx-4">

                            <div class="flex flex-col justify-start text-center">
                                <div class="mx-4">
                                    NFL Survivor
                                </div>
                                <div class="mx-4">
                                    Week {{ $week }}
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mx-4">
                            <div class="flex flex-col justify-end text-center">
                                <div class="mx-4">
                                    Status: @if ($survivor->alive)
                                        <span class="text-green-500 px-2">Alive</span>
                                    @else
                                        <span class="text-red-500">Dead</span>
                                    @endif
                                </div>
                                <div class="mx-4">
                                    Pool: {{ $survivor->pool->name }}
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="flex flex-col lg:grid lg:grid-rows-1 lg:grid-flow-col gap-2 lg:gap-4 items-center pb-2  mx-4">
                    <div class="lg:col-span-3">
                        <div class="column w-full p-2 text-white 4 rounded-xl">
                            <div class="bg-gradient-to-tr from-red-700/90 via-indigo-900/90 to-blue-900/60 rounded-xl  p-4 rounded-xl border-4 border-double">
                                <div class="flex justify-between items-center p-1  text-xs lg:text-sm">

                                    <h1 class="text-primary underline lg:tracking-wide">Grade Ledgar</h1>

                                    <ul class="flex lg:tracking-wide">
                                        <li class="flex inline pr-2">
                                            <div class="badge badge-md bg-white"></div>
                                            <p class="px-1">Pending</p>
                                        </li>
                                        <li class="flex inline px-2">
                                            <div class="badge badge-md bg-green-500"></div>

                                            <p class="px-1">Won</p>
                                        </li>
                                        <li class="flex inline ml-2">
                                            <div class="badge badge-md bg-red-500"></div>
                                            <p class="px-1">Lost</p>
                                        </li>
                                    </ul>
                                </div>

                                <div class="mx-8 lg:mx-14 py-6">
                                    <h1 class="text-center text-lg text-accent">Your Selections:</h1>
                                    <div class="grid grid-cols-3 items-center mt-2 text-xs lg:text-base mx-auto gap-y-2">
                                        @forelse ($mypicks as $pick)
                                            <div class="col-span-2 flex justify-start item-center">
                                                <p @class([
                                                        'text-white/100' => is_null($pick->result),
                                                        'line-through text-red-500 font-bold' => $pick->result === 0,
                                                        'text-green-500/100 font-semibold' => $pick->result === 1,
                                                    ])>
                                                    Week {{ $pick->week }}: {{ $pick->selection }}
                                                </p>
                                            </div>
                                            <div class="col-span-1 flex justify-end item-center">
                                                @if ($pick->result === null)
                                                    <button class="btn btn-sm btn-error"
                                                            wire:click="RemovePick('{{ $pick->selection }}', '{{ $pick->week }}')">
                                                        X
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-success">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>


                                </div>


                                <div class="glass rounded-xl p-2 my-4">

                                    <div class="flex flex-wrap justify-center lg:justify-evenly py-4 items-center">
                                        @if($week > 1 && $realWeek >= $week)
                                            <div class="col pb-2 lg:pb-0">
                                                <div class="flex items-center justify-center">
                                                    <div class="text-center">
                                                        <h1 class="underline tracking-wide text-red-200">Week {{ $week - 1 }}'s
                                                            Biggest Loser</h1>
                                                        <div class="bg-red-500 opacity-80 rounded-xl py-2 px-4 mx-auto my-1">
                                                            <div class="flex justify-between items-center text-center tracking-wide text-sm lg:text-lg">
                                                                @if ($biggestLoser)
                                                                    @foreach ($biggestLoser as $l => $v)

                                                                        <p class="mr-2"> Lives Taken:</p>
                                                                        <div class="btn btn-sm bg-black text-white">{{ $l }}x</div>
                                                                        <p class="ml-2"> | {{ $v }}</p>

                                                                    @endforeach
                                                                @else

                                                                    <p class="mr-2"> Lives Taken:</p>
                                                                    <div class="btn btn-sm bg-black text-white">15x</div> <p
                                                                            class="ml-2"> | Detroit Lions</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col">
                                            <div class="flex items-center justify-center">
                                                <div class="text-center">
                                                    <h1 class="underline tracking-wide text-blue-200">Player Count</h1>
                                                    <div class="bg-blue-500 opacity-80 rounded-xl py-2 px-4 mx-auto my-1">
                                                        <span class="font-bold text-green-500 drop-shadow-lg mr-2">{{ $playerCount['Alive'] }} Alive</span>
                                                        <span class="font-bold text-white">&nbsp;|</span>&nbsp;<span
                                                                class="ml-2 font-bold drop-shadow-lg text-error">{{ $playerCount['Dead'] }} Dead</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="column w-full  text-white my-1">
                                        <div class="flex flex-col">
                                            <div class="col">
                                                <div class="flex flex-col">
                                                    <div>
                                                        <select class="select select-bordered text-center text-xl text-white w-full"
                                                                wire:model.change="week">
                                                            <option disabled selected>Week {{ $week }}</option>
                                                            @foreach(range(1,18) as $k)
                                                                <option class="text-white text-xl" value="{{ $k }}">
                                                                    Week {{ $k }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mt-2">
                                                        <button class="btn btn-primary w-full" wire:click="changeWeek"
                                                                wire:loading.attr="disabled">Change Week
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col glass rounded-2xl">
                        <div class="flex flex-col">
                            <form wire:submit.prevent="submit">
                                <div class="col px-4 pt-4">
                                    <select size="15"
                                            class="select select-success h-full w-full text-center text-white text-3xl rounded-t-xl px-4 pt-4"
                                            wire:model.live="selectTeam">
                                        <option disabled selected class="text-primary text-xl">Select Team</option>
                                        @forelse ($choices as $choice)
                                            <option class="text-white text-xl"> {{ $choice->get('name') }} </option>
                                        @empty
                                            <option class="text-white text-xl"> EMPTY?</option>
                                        @endforelse
                                    </select>
                                </div>
                                @if($week >= $realWeek)
                                    <div class="col pb-4 mx-4">
                                        <button class="btn btn-neutral w-full p-2 rounded-t-none rounded-b-xl" wire:click="submit"
                                                wire:loading.attr="disabled">Select Pick
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>