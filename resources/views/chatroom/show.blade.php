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

    <div class="flex flex-col lg:grid lg:grid-cols-3 lg:space-x-2 lg:divide-x-4 pt-10">
        <div class="row">
            <div class="flex flex-col">
                <div id="menu">
                    <ul class="overflow-auto">
                        @forelse($games as $game)
                        <li href="{{ route('chat.show', ['pool' => $game->pool->id]) }}" wire:navigate class="bg-gray-800 hover:bg-indigo-100 p-2 lg:p-4 border-b border-gray-400">
                            <div class="flex justify-between text-base lg:text-xl">
                                <div>
                                    <p class="lg:font-bold text-primary">{{$game->pool->name}}</p>
                                </div>
                                <div class="flex flex-col text-center place-items-center text-sm">
                                    @if($game->pool->messages->isNotEmpty())
                                    <p class="italic">{{ $game->pool?->messages?->max('created_at')->diffForHumans() ?? '' }}</p>
                                    @else
                                        <p class="italic">No activity</p>
                                    @endif
                                    <p class="text-xs text-accent">{{ $game->pool->Alive->count() }} / {{ $game->pool->contenders->count() }} alive</p>
                                </div>
                            </div>
                        </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="row col-span-2 w-full lg:mx-6">
            <div class="mx-auto rounded-xl bg-gray-800">
                <div class="flex justify-between items-center border-b-2 w-full overflow-hidden p-4">
                    <div class="flex justify-start">
                        <div class="flex flex-1">
                            <h1 class="text-primary font-semibold">Chat</h1>
                            <h3 class="text-secondary italic text-sm place-self-center pl-2">Server Time: {{now()->format('Y-m-d G:ia')}}</h3>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <div class="flex flex-1">
                            <h1 class="text-accent font-bold px-2">{{ $pool->name }}</h1>
                            <img class="h-4 place-self-center" src="https://survivor.nbz.one/images/icons/link.png" />
                        </div>
                    </div>
                </div>

                <livewire:chat-room :pool="$pool" />

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                Echo.join('game.chatroom.{{$pool->id}}')
                    .listen('NewChatroomMessageEvent', (e) => {
                        console.log(e.message)
                    });
            });
        </script>
    @endpush


</x-layouts.landing>