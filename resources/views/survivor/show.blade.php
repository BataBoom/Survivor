<x-layouts.survivor>

    <x-slot:title>{{ucwords($pool->name)}} | {{ucfirst($pool->type)}}</x-slot:title>
    <x-slot:header>



        <div x-data="{ selectedSurvivorId: null }">
            @forelse(Auth::user()->pickemPools as $pickemPool)
                <div class="flex justify-center">
                    <div>
                        <a class="btn btn-sm btn-primary m-2" href="{{ route('pickem.stats', ['pool' => $pickemPool->pool_id]) }}" wire:navigate>
                            Stats {{$pickemPool->pool->name}}
                        </a>
                    </div>
                    <div>
                        <a class="btn btn-sm btn-primary m-2" href="{{ route('pool.show', ['pool' => $pickemPool->pool_id]) }}" wire:navigate>
                            Go to {{$pickemPool->pool->name}}
                        </a>
                    </div>
                </div>
            @empty
            @endforelse


            @forelse($mySurvivorPools as $survivorPool)
                <div class="flex justify-center">
                    <div>


                    <button
                            class="btn btn-sm btn-primary my-2"
                            @click="selectedSurvivorId = selectedSurvivorId === '{{ $survivorPool->id }}' ? null : '{{ $survivorPool->id }}'">
                        Show {{$survivorPool->pool->name}}
                    </button>
                    </div>

                        <div>
                    <a class="btn btn-sm btn-primary m-2" href="{{ route('pool.show', ['pool' => $survivorPool->pool->id]) }}" wire:navigate>
                        Go to {{$survivorPool->pool->name}}
                    </a>
                        </div>
                </div>
                <div class="box p-2" x-show="selectedSurvivorId === '{{ $survivorPool->id }}'">
                    <ul class="text-center">
                        <li>Pool: {{$survivorPool->pool->name}}</li>
                        <li>Max Lives: {{$survivorPool->pool->lives_per_person}}</li>
                        <li>Status: @if($survivorPool->alive) <span class="text-success"> Alive</span> @else <span class="text-error">Dead</span>@endif</li>
                        <li>My Lives: {{$survivorPool->lives_count}}</li>
                        <li>Prize: {{$survivorPool->pool->prize_type}}</li>
                        <li>Starting Contestants: {{ $survivorPool->pool->users->count() }}</li>
                        <li>Remaining Contestants: {{ $survivorPool->pool->survivors->count() }}</li>
                    </ul>
                </div>
            @empty
                <p>No survivor pools found.</p>
            @endforelse
        </div>

    </x-slot:header>
    <div class="flex justify-center mx-auto">
        <div class="flex-flex-col">
            <div>
                
            <livewire:survivor-game :pool="$pool" />
            </div>

            @can('view', $globalPickem)
            <div>
                <livewire:pickem :pool="$globalPickem" />
            </div>
            @else
                <div class="text-center justify-center max-w-4xl">
                <h1 class="text-red-500 text-3xl">Cannot view Pickem Game: {{$pool->name}}</h1>
                    <a href="{{ route('pool.register', ['pool' => $globalPickem->id]) }}" wire:navigate class="btn btn-success p-2 btn-block">Register?</a>
                </div>
                @endif
            <div>

            </div>
{{--
            <div>
                <div class="column w-full p-4">
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

                                    <div id="body" class="text-white text-xl items-center rounded-b-xl">
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
                </div>
            </div>
        </div>
--}}
    </div>
    </div>

</x-layouts.survivor>
