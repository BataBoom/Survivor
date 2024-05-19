<div class="flex flex-col"  wire:poll>
    <div class="column mx-auto text-center my-4">
       <ul>
           <li>Pick'em Pool: {{$pool->name}}</li>
       </ul>
    </div>

        <div class="col">
            <div class="flex flex-col">
                <div>
                    <select class="select select-bordered text-center text-xl text-white w-full"
                            wire:model.lazy="week">
                        <option disabled selected>Week {{ $whatweek }}</option>
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
<div>
<div class="flex justify-center max-w-7xl mx-auto">
    <div class='flex flex-col lg:grid lg:grid-cols-3 lg:gap-4 justify-center mx-auto'>
        @foreach($allGames as $game)
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
                        <div class="flex justify-evenly" x-data="{ selectedSurvivorId: null }">
                            @if($week >= $whatweek)
                                @php

                                    $locate[$game->gid] = $mypicks->where('game_id', $game->gid)->first()?->selection_id ?? false;
                                    //$hasPick = $locate ? true : false;
                                    $isHighlighted = true;
                                @endphp

                                <img

                                        wire:click="pickGame('{{$game->gid}}','{{ $game->info->first()->name }}','{{ $game->info->first()->team_id }}')"
                                        @click="selectedSurvivorId = selectedSurvivorId === '{{ $game->info->first()->team_id }}' ? null : '{{ $game->info->first()->team_id }}'"
                                        
                                        @class(['h-24', 'opacity-50' => $locate[$game->gid] && $locate[$game->gid] === $game->info->last()->team_id])

                                        src="https://survivor.nbz.one/images/logo/nfl/{{ trim(str_replace(' ', '', $game->info->first()->name)) }}.png">
                                <img
                                        wire:click="pickGame('{{$game->gid}}','{{ $game->info->last()->name }}','{{ $game->info->last()->team_id }}')"
                                        @click="selectedSurvivorId = selectedSurvivorId === '{{ $game->info->last()->team_id }}' ? null : '{{ $game->info->last()->team_id }}'"
                                        @class(['h-24', 'opacity-50' => $locate[$game->gid] && $locate[$game->gid] === $game->info->first()->team_id])
                                        src="https://survivor.nbz.one/images/logo/nfl/{{ trim(str_replace(' ', '', $game->info->last()->name)) }}.png">

                            @else
                                <div class="flex flex-col text-center items-center">
                                    <div>
                                    <img
                                            class="h-24"
                                            :class="{ 'opacity-50': '{{ $game->result->winner }}' !== '{{ $game->info->first()->team_id }}' }"
                                            src="https://survivor.nbz.one/images/logo/nfl/{{ trim(str_replace(' ', '', $game->info->first()->name)) }}.png">
                                    </div>
                                    <div>
                                        <p>
                                            {{ $game->result->home_score }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col text-center items-center">
                                    <div>
                                        <img
                                                class="h-24"
                                                :class="{ 'opacity-50': '{{ $game->result->winner }}' !== '{{ $game->info->last()->team_id }}' }"
                                                src="https://survivor.nbz.one/images/logo/nfl/{{ trim(str_replace(' ', '', $game->info->last()->name)) }}.png">
                                    </div>
                                    <div>
                                        <p>
                                            {{ $game->result->away_score }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($week >= $whatweek)
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
                        @else
                            <!-- Should consider making a diff view for Results,as  I did in version 1.. --->
                            <div class="flex flex-col text-center my-4">
                                <div>
                                    Result: {{$game->result->winner_name}}
                                </div>
                                <div>
                                    My Pick: {{ $mypicks->where('game_id', $game->gid)->first()?->selection ?? 'None' }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
    @endforeach
    </div>
</div>
</div>
</div>