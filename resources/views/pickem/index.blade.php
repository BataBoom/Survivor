<x-layouts.survivor>

    <x-slot:title>{{ucwords($pool->name)}} | {{ucfirst($pool->type)}}</x-slot:title>
    <x-slot:header>

        <div x-data="{ selectedSurvivorId: null }">
            @forelse(Auth::user()->pickemPools as $pickemPool)
                <div class="flex justify-center">
                    <a class="btn btn-sm btn-primary m-2" href="{{ route('pickem.wire', ['pool' => $pickemPool->pool_id]) }}" wire:navigate>
                        Go to {{$pickemPool->pool->name}}
                    </a>
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
                <livewire:survivor-game :currentPool="$pool" :survivor="$survivor" />
            </div>

            <div>
                <livewire:pickem :pool="$globalPickem" />
            </div>

        </div>
    </div>

</x-layouts.survivor>