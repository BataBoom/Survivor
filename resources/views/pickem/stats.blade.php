<x-layouts.survivor>

    <x-slot:title>Pickem Stats</x-slot:title>
    <x-slot:header>

        <div x-data="{ selectedSurvivorId: null }">
                <div class="flex justify-around">
                    <div>
                        <a
                                class="btn btn-primary btn-sm text-xs mx-2"
                                href="{{ route('chat.show', ['pool' => $pool->id]) }}" wire:navigate>Go to {{$pool->name}} Chat</a>
                    </div>
                    <div>
                    <a class="btn btn-success btn-sm text-xs mx-2" href="{{ route('pickem.wire', ['pool' => $pool->id]) }}" wire:navigate>
                        Go to {{$pool->name}}
                    </a>
                    </div>
                </div>
        </div>

    </x-slot:header>
    <div class="flex justify-center mx-auto">
        <div class="flex-flex-col space-y-2">
            {{--
            <div>
                <a class="btn btn-sm" @click="leaderboard = ! leaderboard" x-text="leaderboard ? 'Hide Leaderboard' : 'Show Leaderboard'" :class="leaderboard ? 'btn-error' : 'btn-primary'">

                </a>
            </div>
            <div>
                <a class="btn btn-sm" @click="pickemstable = ! pickemstable" x-text="pickemstable ? 'Hide Pickem Log' : 'Show Pickem Log'" :class="pickemstable ? 'btn-error' : 'btn-primary'">

                </a>
            </div>
            --}}
            <div class="col w-full">
                <livewire:pickem-stats :pool="$pool" />
            </div>
        </div>
    </div>

</x-layouts.survivor>