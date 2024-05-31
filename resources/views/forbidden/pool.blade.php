<x-layouts.survivor>

    <x-slot:title>{{ $type.' '.$pool->name }} | Forbidden </x-slot:title>
 <x-slot:header>
     <h1>You're forbidden from accessing {{$type}} pool: {{$pool->name}}</h1>
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

            <h1>About {{$pool->name}}</h1>
            <div class="flex flex-col justify-center mt-16">
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead>
                        <tr class="text-center">

                            <th>Pool Type</th>
                            <th>Name</th>
                            <th>Prize</th>
                            <th>Actions</th>
                            <th>Status</th>
                            <th>Starting/Max Lives</th>
                            <th>Starts</th>
                            <th>Registered</th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr class="hover text-center">
                                <td>{{ ucfirst($pool->type) }}</td>
                                <td>{{ $pool->name }}</td>
                                <td>{{ $pool->prize_type }} @if($pool->prize) |  {{ $pool->prize }} @endif</td>
                                <td>
                                    @if(Auth::user()->is($pool->creator))
                                    <a      class="btn btn-success"
                                            href="{{ route('pool.setup', ['pool' => $pool->id]) }}" wire:navigate>Finish Set up, Pay Entry Fee: ${{$pool->entry_cost }} @if($pool->guaranteed_prize > 1) + Guaranteed: ${{$pool->guaranteed_prize }} @endif</a>
                                    @else
                                        <a      class="btn btn-sm btn-success"
                                                href="{{ route('pool.register', ['pool' => $pool->id]) }}" wire:navigate>Register, Entry Fee: ${{$pool->entry_cost }}</a>
                                    @endif
                                </td>
                                <td>{{ now()->greaterThan(Config::get('survivor.start_date')) ? 'In progress' : 'Registering' }}</td>
                                <td>{{ $pool->lives_per_person }}</td>
                                <td> {{ Config::get('survivor.start_date')->diffForHumans() .' / '.Config::get('survivor.start_date')->format('jS \o\f F, Y')}}</td>
                                <td>{{ $pool->users->count() }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="column pt-6 px-8">

                    <div class="flex justify-evenly">
                        <a href="{{ route('pools.browse') }}" class="btn btn-primary w-1/2 mx-4" wire:navigate>Browse Pools</a>
                        <a class="btn btn-success w-1/2 mx-4">Create Pool</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.survivor>