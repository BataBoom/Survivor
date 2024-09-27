<div class="flex flex-col max-w-7xl mx-auto">
    <div class="column mx-auto text-center my-4">
       <ul>
           <li>Pick'em Pool: {{$pool->name}} </li>
           <li class="my-2">Tap a Team Logo to update your pick</li>
       </ul>
    </div>
@if (Route::currentRouteName() != 'pickem.stats')
<div class="col text-center">
    <div class="flex justify-between">
        <div>
            <a class="btn btn-primary btn-sm text-xs mx-2"
                    href="{{ route('chat.show', ['pool' => $pool->id]) }}" wire:navigate>Go to {{$pool->name}} Chat</a>
        </div>
        <div>
            <a class="btn btn-success btn-sm text-xs mx-2" href="{{ route('pickem.stats', ['pool' => $pool->id]) }}" wire:navigate>
                 Go to {{ $pool->name }} Leaderboard
            </a>
        </div>
    </div>
</div>
@endif

    <div class="col">
        <div class="flex flex-col">
            <div>
                <h1 class="text-xl underline text-center mb-1">Change Week</h1>
                <select class="select select-primary select-bordered text-center text-xl text-white w-full"
                        wire:model.change="week">
                    <option disabled selected>Week {{ $whatweek }}</option>
                    @foreach(range(1,18) as $k)
                        <option class="text-white text-xl" value="{{ $k }}">
                            Week {{ $k }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
<div>
<div class="flex justify-center max-w-7xl mx-auto">
<div class='flex flex-col lg:grid lg:grid-cols-3 lg:gap-4 justify-center mx-auto'>
    @foreach($allGames as $key => $game)
        <div class="col my-6 lg:my-4">
            <div class="container max-w-md min-h-96 flex flex-col">
                <div id="top" class="bg-neutral-800 text-white text-xl items-center rounded-t-xl">
                    <div class="grid grid-cols-1 grid-rows-2 gap-y-1 text-center mx-auto border-b-2 border-dotted border-sky-500">
                        <div class="row text-base tracking-widest">
                            <h1>{{ $game->game }}</h1>
                        </div>
                        <div class="row text-sm tracking-wide italic">
                            <div class="flex flex-col">
                                <h4> {{ $game->starts }}</h4>
                            @if (session('status'.$game->gid))
                                <p class="text-success"> {{ session('status'.$game->gid) }} </p>
                            @endif
                            </div>
                        </div>

                    </div>
                </div>


                <div id="body" class="text-white text-xl items-center rounded-b-xl">

                    <div class="flex justify-evenly">
                        @if(is_null($game->result))

                            <img

                                    wire:click="pickGame('{{$game->gid}}','{{ $game->teams->away->name }}','{{ $game->teams->away->team_id }}')"
                                    @class([
                                    'h-24 opacity-50' => $mypicks->where('game_id', $key)->isEmpty() || $mypicks->where('game_id', $key)->first()->selection_id !== $game->teams->away->team_id,
                                    'h-32 opacity-100' => $mypicks->where('game_id', $key)->isNotEmpty() && $mypicks->where('game_id', $key)->first()->selection_id === $game->teams->away->team_id])

                                    src="https://survivor.nbz.one/nfl-logos/{{ trim(str_replace(' ', '', $game->teams->away->name)) }}.png">
                            <img
                                    wire:click="pickGame('{{$game->gid}}','{{ $game->teams->home->name }}','{{ $game->teams->home->team_id }}')"
                                    @class([
                                    'h-24 opacity-50' => $mypicks->where('game_id', $key)->isEmpty() || $mypicks->where('game_id', $key)->first()->selection_id !== $game->teams->home->team_id,
                                    'h-32 opacity-100' => $mypicks->where('game_id', $key)->isNotEmpty() && $mypicks->where('game_id', $key)->first()->selection_id === $game->teams->home->team_id])
                                    src="https://survivor.nbz.one/nfl-logos/{{ trim(str_replace(' ', '', $game->teams->home->name)) }}.png">


                        @else
                            <div class="flex flex-col text-center items-center">
                                <div>
                                    <img
                                            @class([
                                            "h-24",
                                            "opacity-50" => $game->result?->winner !== $game->teams->away->team_id,
                                            "opacity-100" => $game->result?->winner === $game->teams->away->team_id
                                    ])
                                            src="https://survivor.nbz.one/nfl-logos/{{ trim(str_replace(' ', '', $game->teams->away->name)) }}.png">
                                </div>
                                <div>
                                    <p>
                                        {{ $game->result?->away_score }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col text-center items-center">
                                <div>
                                <img @class([
                                            "h-24",
                                            "opacity-50" => $game->result?->winner !== $game->teams->home->team_id,
                                            "opacity-100" => $game->result?->winner === $game->teams->home->team_id

                                    ])
                                        src="https://survivor.nbz.one/nfl-logos/{{ trim(str_replace(' ', '', $game->teams->home->name)) }}.png">
                                </div>
                                <div>
                                    <p>
                                        {{ $game->result?->home_score }}
                                    </p>
                                </div>
                            </div>

                        @endif
                    </div>

                    @if(is_null($game->result))
                        <div class="flex flex-wrap justify-around text-white">
                            <div>
                                <a
                                        style="background: linear-gradient({{ $game->teams->away->altColor }}, {{ $game->teams->away->color }});"
                                        class="btn w-24 m-4"
                                        href="https://www.espn.com/nfl/team/depth/_/name/{{ $game->teams->away->abbreviation }}"
                                        target="_blank"
                                >{{ $game->teams->away->abbreviation }} Depth</a>
                                <a
                                        style="background: linear-gradient({{ $game->teams->home->altColor }}, {{ $game->teams->home->color }});"
                                        class="btn w-24 m-4"
                                        href="https://www.espn.com/nfl/team/depth/_/name/{{ $game->teams->home->abbreviation }}"
                                        target="_blank"
                                >{{ $game->teams->home->abbreviation }} Depth</a>
                            </div>
                            <div>
                                <a
                                        style="background: linear-gradient({{ $game->teams->away->altColor }}, {{ $game->teams->away->color }});"
                                        class="btn w-24 m-4"
                                        href="https://www.espn.com/nfl/team/injuries/_/name/{{ $game->teams->away->abbreviation }}"
                                        target="_blank"
                                >{{ $game->teams->away->abbreviation }} Injuries</a>
                                <a
                                        style="background: linear-gradient({{ $game->teams->home->altColor }}, {{ $game->teams->home->color }});"
                                        class="btn w-24 m-4"
                                        href="https://www.espn.com/nfl/team/injuries/_/name/{{ $game->teams->home->abbreviation }}"
                                        target="_blank"
                                >{{ $game->teams->home->abbreviation }} Injuries</a>
                            </div>
                            <a
                                    style="-webkit-text-stroke: 1px #fbe7af;color: white; backdrop-filter: blur(50px);background: linear-gradient(to right, {{ $game->teams->away->color }}, {{ $game->teams->away->altColor }}, {{ $game->teams->home->color }}, {{ $game->teams->home->altColor }});"
                                    class="btn text-xl w-5/6 my-4"
                                    href="https://www.espn.com/nfl/game/_/gameId/{{$key}}"
                                    target="_blank"
                            >Game Preview</a>
                        </div>
                    @else
                        <!-- Should consider making a diff view for Results,as  I did in version 1.. --->
                        <div class="flex flex-col text-center my-4">
                            @if($mypicks->where('game_id', $game->gid)->first())
                            <div @class(['text-green-500' => $game->result?->winner === $mypicks->where('game_id', $game->gid)->first()?->selection_id, 'text-red-500 line-through' => $game->result?->winner !== $mypicks->where('game_id', $game->gid)->first()?->selection_id ])>
                                My Pick: {{ $mypicks->where('game_id', $game->gid)->first()?->selection ?? 'None' }}
                            </div>
                                <div class="text-sm text-slate-400">
                                    Result: {{$game->result->winner_name}}
                                </div>
                            @else
                                <div class="text-sm text-slate-400">No vote</div>
                                <div class="text-sm text-slate-400">
                                    Result: {{$game->result->winner_name}}
                                </div>
                            @endif
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