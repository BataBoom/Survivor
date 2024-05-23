<x-layouts.survivor>

    <x-slot:title>Browsing Pools </x-slot:title>
    <x-slot:header>
        <h1>Browsing Pools *Filters* </h1>
    </x-slot:header>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col justify-center mt-16">
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead>
                        <tr class="text-center">

                            <th>Pool Type</th>
                            <th>Name</th>
                            <th>Prize</th>
                            <th>Entry Fee</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Start Lives</th>
                            <th>Users</th>
                            <th>Starts</th>


                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pools as $pool)
                            <tr class="hover text-center">
                                <td>{{ ucfirst($pool->type) }}</td>
                                <td>{{ $pool->name }}</td>
                                <td>{{ $pool->prize_type }} @if($pool->prize) |  {{ $pool->prize }} @endif</td>
                                <th>{{ $pool->entry_fee ?? 'FREE' }}</th>
                                <td>{{ now()->greaterThan($start_date) ? 'In progress' : 'Registering' }}</td>
                                <td>
                                    @can('view', $pool)

                                    <a
                                            class="btn btn-sm btn-primary"
                                            href="{{ route('pool.show', ['pool' => $pool->id]) }}" wire:navigate>View</a>
                                    @else
                                        <a
                                                class="btn btn-sm btn-success"
                                                href="{{ route('pool.register', ['pool' => $pool->id]) }}" wire:navigate>Register {{ $pool->entry_fee }}</a>
                                    @endcan
                                </td>
                                <td>{{ $pool->lives_per_person }}</td>
                                <td>{{ $pool->users->count() }}</td>

                                <td> {{ $start_date->diffForHumans() .' / '.$start_date->format('jS \o\f F, Y')}}</td>

                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="column pt-6 px-8">

                    <div class="flex justify-evenly">
                        <a href="{{ route('pool.create') }}" class="btn btn-success w-1/2 mx-4" wire:navigate>Create Pool</a>
                        <a  href="{{ route('mypools.show') }}" class="btn btn-primary w-1/2 mx-4"  wire:navigate>My Pools</a>
                    </div>



                </div>
            </div>
        </div>
    </div>
</x-layouts.survivor>