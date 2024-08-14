<x-layouts.survivor>

    <x-slot:title>{{ $type.' '.$pool->name }} | Edit </x-slot:title>
    <x-slot:header>
        <h1>Managing {{strtoupper($pool->name)}}</h1>
    </x-slot:header>


    <div class="py-12">

        @session('success')
        <div class="flex justify-center">
            <div class="p-4 bg-green-500 rounded-xl max-w-7xl text-white text-xl text-center">
                {{ $value }}
            </div>
        </div>
        @endsession

        @session('error')
        <div class="flex justify-center">
            <div class="p-4 bg-red-500 rounded-xl max-w-7xl text-white text-xl text-center">
                {{ $value }}
            </div>
        </div>
        @endsession

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <h1>Contestants</h1>
            <div class="flex flex-col justify-center mt-16">
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead>
                        <tr class="text-center">

                            <th>Name</th>
                            <th>Status</th>
                            <th>Registered</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($contenders as $contender)
                        <tr class="hover text-center">
                            <td>{{ $contender->user->name }}</td>
                            <td @class(['text-green-500' => $contender->alive, 'text-red-500' => !$contender->alive])>{{ $contender->alive ? 'Alive' : 'Dead' }}</td>
                            <td>{{ $contender->created_at->diffForHumans() }} </td>
                        </tr>
                        @empty
                        @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="column pt-6 px-8">
                    <div class="flex justify-evenly">
                        <a href="{{ route('chat.show', ['pool' => $pool->id ]) }}" class="btn btn-warning w-1/2 mx-4">Pool Chat</a>
                        <a href="{{ route('pools.browse') }}" class="btn btn-primary w-1/2 mx-4" wire:navigate>Browse Pools</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.survivor>