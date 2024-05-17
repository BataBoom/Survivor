<div class="container max-w-7xl sm:mx-6 md:mx-6 lg:mx-auto mt-16 mb-10">
            <div id="body" class="container mx-auto bg-gradient-to-bl from-red-800 via-violet-800 to-blue-500 rounded-3xl">
                <div class="bg-neutral-800 text-white text-xl items-center rounded-t-xl p-4 mb-2">
                    <div class="flex justify-between">
                        <div class="flex justify-start">
                            NFL Survivor - Week {{ $week }} | @if ($status) <span class="text-green-500 px-2">Alive</span>  @else <span class="text-red-500">Dead</span> @endif
                        </div>
                        <div class="flex justify-end">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
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


                                <div class="flex justify-between pt-6 text-xs lg:text-sm max-h-64 overflow-auto">
                                    <div class="flex justify-start px-2 items-center">
                                        <h1 class="text-primary underline tracking-wide">Your Picks: </h1>
                                    </div>
                                    <div class="flex justify-end">
                                        <ul class="tracking-wide">
                                            @forelse ($mypicks as $pick)
                                                <li class="text-{{ $pick->result ? 'success' : 'danger' }}">
                                                    Week {{ $pick->week }}: {{ $pick->selection }}
                                                    @if ($pick->result === null)
                                                        <button class="btn btn-sm btn-error text-xs m-2">Delete</button>
                                                    @endif
                                                </li>
                                                <li>
                                                    <button class="btn btn-sm btn-error text-xs m-2">Delete</button>
                                                </li>
                                            @empty
                                            @endforelse

                                        </ul>
                                    </div>
                                </div>

                                <div class="glass rounded-xl p-4 my-4">
                                    <div class="flex justify-evenly py-3 items-center">
                                        <div class="col">
                                            <h1 class="text-center pb-1 underline tracking-wide text-red-200">Week {{ $week - 1 }}'s Biggest Loser</h1>
                                            <div class="bg-red-500 opacity-80 rounded-xl px-2 mx-auto text-center p-2 text-lg">
                                                @if ($biggestLoser)
                                                    @foreach ($biggestLoser as $l => $v)
                                                       <p class="flex"> Lives Taken: <span class="inline text-error">{{ $l }}x</span> | {{ $v }}</p>
                                                    @endforeach
                                                @else
                                                    No Losers
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col">
                                            <h1 class="text-center pb-1 underline tracking-wide text-blue-200">Player Count</h1>
                                            <div class="bg-blue-500 rounded-xl opacity-80 px-2 mx-auto text-center p-2 text-lg">
                                                <span class="flex text-green-500">{{ $playerCount['Alive'] }} Alive | </span><span class="inline text-error">{{ $playerCount['Dead'] }} Dead</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column w-full  text-white my-1">
                                        <div class="flex flex-col">
                                            <div class="col">
                                                <div class="flex flex-col">
                                                    <div>
                                                        <select class="select select-bordered text-center text-xl text-white w-full" wire:model.lazy="newweek">
                                                            <option disabled selected>Week {{ $whatweek }}</option>
                                                            @foreach(range(0,18) as $k => $v)
                                                                <option class="text-white text-xl" value="{{ $k }}">Week {{ $k }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mt-2">
                                                        <button class="btn btn-primary w-full" wire:click="changeWeek" wire:loading.attr="disabled">Change Week</button>
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
                                    <select multiple size="15" class="select select-success h-full w-full text-center text-white text-3xl rounded-t-xl px-4 pt-4" wire:model.defer="pickteam">
                                        <option disabled selected class="text-primary text-xl">Select Team</option>
                                        @forelse ($choices as $choice)
                                        <option class="text-white text-xl"> {{ $choice->get('name') }} </option>
                                        @empty
                                            <option class="text-white text-xl"> EMPTY? </option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col pb-4 mx-4">
                                    <button class="btn btn-neutral w-full p-2 rounded-t-none rounded-b-xl" wire:click="submit" wire:loading.attr="disabled">Select Pick</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>