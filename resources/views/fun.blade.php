<x-layouts.survivor>

    <x-slot:title>Fun</x-slot:title>

    <div class="flex justify-center max-w-7xl mx-auto">
    <div class="container w-full sm:mx-6 md:mx-6 lg:mx-auto mt-16 mb-10">
            <div id="body" class="container mx-auto bg-gradient-to-bl from-red-800 via-violet-800 to-blue-500 rounded-3xl">
                <div class="bg-neutral-800 text-white text-xl items-center rounded-t-xl p-4 mb-2">
                    <div class="flex justify-between">
                        <div class="flex justify-start">
                            Survior Week 14 | <span class="text-green-500 px-2">Alive</span>
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
                                            <li style="color:#75ff33;"> Week 1: Detroit Lions </li>
                                            <li style="color:#75ff33;">Week 2: Jacksonville Jaguars </li>
                                            <li style="color:#75ff33;">Week 3: Cleveland Browns </li>
                                            <li style="color:#fff;">Week 4: Buffalo Bills </li>
                                            <li style="color:#fff;">Week 5: Carolina Panthers </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="glass rounded-xl p-4 my-4">
                                    <div class="flex justify-evenly py-3 items-center">
                                        <div class="col">
                                            <h1 class="text-center pb-1 underline tracking-wide text-red-200">Week 3's Biggest Loser:</h1>
                                            <div class="bg-red-500 opacity-80 rounded-xl px-2 mx-auto text-center p-2 text-lg">
                                                Lives Taken: 6x | Cincinnati Bengals
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h1 class="text-center pb-1 underline tracking-wide text-blue-200">Player Count</h1>
                                            <div class="bg-blue-500 rounded-xl opacity-80 px-2 mx-auto text-center p-2 text-lg">
                                                131 Alive | 160 Total
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column w-full  text-white my-1">
                                        <div class="flex flex-col">
                                            <div class="col">
                                                <div class="flex flex-col">
                                                    <div>
                                                        <select class="select select-bordered text-center text-xl text-white w-full">
                                                            <option disabled selected>Week 4</option>
                                                            <option class="text-white text-xl">Week 1</option>
                                                            <option class="text-white text-xl">Week 2</option>
                                                            <option class="text-white text-xl">Week 3</option>
                                                        </select>
                                                    </div>
                                                    <div class="mt-2">
                                                        <button class="btn btn-primary w-full">Change Week</button>
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
                            <div class="col px-4 pt-4">
                                <select multiple size="15" class="select select-success h-full w-full text-center text-white text-3xl rounded-t-xl px-4 pt-4">
                                    <option disabled selected class="text-primary text-xl">Select Team</option>
                                    <option class="text-white text-xl"> Arizona Cardinals</option>
                                    <option class="text-white text-xl"> Atlanta Falcons</option>
                                    <option class="text-white text-xl"> Baltimore Ravens</option>
                                    <option class="text-white text-xl"> Buffalo Bills</option>
                                    <option class="text-white text-xl"> Carolina Panthers</option>
                                    <option class="text-white text-xl"> Chicago Bears</option>
                                    <option class="text-white text-xl"> Cincinnati Bengals</option>
                                    <option class="text-white text-xl"> Cleveland Browns</option>
                                    <option class="text-white text-xl"> Dallas Cowboys</option>
                                    <option class="text-white text-xl"> Denver Broncos</option>
                                    <option class="text-white text-xl"> Detroit Lions</option>
                                    <option class="text-white text-xl"> Green Bay Packers</option>
                                    <option class="text-white text-xl"> Houston Texans</option>
                                    <option class="text-white text-xl"> Indianapolis Colts</option>
                                    <option class="text-white text-xl"> Jacksonville Jaguars</option>
                                    <option class="text-white text-xl"> Kansas City Chiefs</option>
                                    <option class="text-white text-xl"> Las Vegas Raiders</option>
                                    <option class="text-white text-xl"> Los Angeles Chargers</option>
                                    <option class="text-white text-xl"> Los Angeles Rams</option>
                                    <option class="text-white text-xl"> Miami Dolphins</option>
                                    <option class="text-white text-xl"> Minnesota Vikings</option>
                                    <option class="text-white text-xl"> New England Patriots</option>
                                    <option class="text-white text-xl"> New Orleans Saints</option>
                                    <option class="text-white text-xl"> New York Giants</option>
                                    <option class="text-white text-xl"> New York Jets</option>
                                    <option class="text-white text-xl"> Philadelphia Eagles</option>
                                    <option class="text-white text-xl"> Pittsburgh Steelers</option>
                                    <option class="text-white text-xl"> San Francisco 49ers</option>
                                    <option class="text-white text-xl"> Seattle Seahawks</option>
                                    <option class="text-white text-xl"> Tampa Bay Buccaneers</option>
                                    <option class="text-white text-xl"> Tennessee Titans</option>
                                    <option class="text-white text-xl"> Washington Commanders</option>
                                </select>
                            </div>
                            <div class="col pb-4 mx-4">
                                <button class="btn btn-neutral w-full p-2 rounded-t-none rounded-b-xl">Select Pick</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>

    <div class="flex justify-center max-w-7xl mx-auto">
    <div class='flex flex-col lg:grid lg:grid-cols-3 lg:gap-4 justify-center mx-auto'>
        @foreach($games as $game)
            <div class="col my-6 lg:my-4">
                <div class="container max-w-md min-h-96 flex flex-col">
                <div id="top" class="bg-neutral-800 text-white text-xl items-center rounded-t-xl">
                    <div class="grid grid-cols-1 grid-rows-2 text-center mx-auto p-2 border-b-2 border-dotted border-sky-500">
                        <div class="row text-base tracking-widest">
                            <h1>{{ $game->game }}</h1>
                        </div>
                        <div class="row text-sm tracking-wide italic">
                            <h4> {{ date('l F jS', strtotime($game->starts)) }}</h4>
                        </div>
                    </div>
                </div>

                <div id="body" class="bg-neutral-500 text-white text-xl items-center rounded-b-xl">
                    <div class="flex justify-evenly">
                        <img src="https://survivor.nbz.one/images/logo/nfl/{{ trim(str_replace(' ', '', $game->info->first()->name)) }}.png" class="h-24">
                        <img src="https://survivor.nbz.one/images/logo/nfl/{{ trim(str_replace(' ', '', $game->info->last()->name)) }}.png" class="h-24">
                    </div>
                    <div class="flex flex-wrap justify-around text-white">
                        <div>
                            <button style="background: linear-gradient(#{{ $game->info->first()->altColor }}, #{{ $game->info->first()->color }});" class="btn w-24 m-4">{{ $game->info->first()->abbreviation }} Depth</button>
                            <button style="background: linear-gradient(#{{ $game->info->last()->altColor }}, #{{ $game->info->last()->color }});" class="btn w-24 m-4">{{ $game->info->last()->abbreviation }} Depth</button>

                        </div>
                        <div>
                            <button style="background: linear-gradient(#{{ $game->info->first()->altColor }}, #{{ $game->info->first()->color }});" class="btn w-24 m-4">{{ $game->info->first()->abbreviation }} Injuries</button>
                            <button style="background: linear-gradient(#{{ $game->info->last()->altColor }}, #{{ $game->info->last()->color }});" class="btn w-24 m-4">{{ $game->info->last()->abbreviation }} Injuries</button>
                        </div>
                        <button style="background: linear-gradient(to right, #{{ $game->info->first()->color }}, #{{ $game->info->first()->altColor }}, #{{ $game->info->last()->color }}, #{{ $game->info->last()->altColor }});" class="btn text-xl w-5/6 my-4">Game Preview</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>




</x-layouts.survivor>
