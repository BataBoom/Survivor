<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Browsing Pools') }}
        </h2>
    </x-slot
    <x-slot:title>Browsing Pools </x-slot:title>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h1 class="text-xl text-accent underline px-2">Official Pools </h1>
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
                            <th>Copy</th>


                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sitePools as $pool)
                            <tr class="hover text-center">
                                <td>{{ ucfirst($pool->type) }}</td>
                                <td>{{ $pool->name }}</td>
                                <td>{{ $pool->total_prize }}</td>

                                <th>{{ $pool->entry_cost ?? 'FREE' }}</th>
                                <td>{{ now()->greaterThan($start_date) ? 'In progress' : 'Registering' }}</td>
                                <td>
                                    @can('view', $pool)

                                        <a
                                                class="btn btn-sm btn-primary"
                                                href="{{ route('pool.show', ['pool' => $pool->id]) }}" wire:navigate>View</a>
                                    @endcan

                                    @cannot('view', $pool)
                                        @if(now()->lessThan(Config::get('survivor.start_date')))
                                            <a      class="btn btn-sm btn-success"
                                                    href="{{ route('pool.register', ['pool' => $pool->id]) }}">Register, Entry Fee: {{$pool->entry_cost }}</a>
                                        @else
                                        <button class="btn btn-sm disabled">Registration Concluded</button>
                                        @endif
                                        
                                    @endcan
                                </td>
                                @if($pool->type == 'pickem')
                                <td>N/A</td>
                                @else
                                <td>{{ $pool->lives_per_person }}</td>
                                @endif
                            
                                <td>{{ $pool->users?->count() }}</td>

                                <td> {{ $start_date->diffForHumans() .' / '.$start_date->format('jS \o\f F, Y')}}</td>
                                <td>
                                    <a class="btn btn-sm" x-clipboard.raw="{{ route('pool.show', ['pool' => $pool->id]) }}">
                                        <svg className="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" strokeLinejoin="round" strokeWidth="2" d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z"/>
                                        </svg>
                                    </a>
                                </td>

                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h1 class="text-xl text-accent underline px-2">Community Pools</h1>
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
                            <th>Copy</th>


                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pools as $pool)
                            <tr class="hover text-center">
                                <td>{{ ucfirst($pool->type) }}</td>
                                <td>{{ $pool->name }}</td>
                                <td>{{ $pool->prize_type }} @if($pool->total_prize) |  {{ $pool->total_prize }} (USD) @endif</td>

                                <th>${{ $pool->entry_cost ?? 'FREE' }}</th>
                                <td>{{ now()->greaterThan($start_date) ? 'In progress' : 'Registering' }}</td>
                                <td>
                                    @can('view', $pool)

                                    <a
                                            class="btn btn-sm btn-primary"
                                            href="{{ route('pool.show', ['pool' => $pool->id]) }}" wire:navigate>View</a>
                                    @endcan
                                    @cannot('view', $pool)
                                    
                                        @if(now()->lessThan(Config::get('survivor.start_date')))
                                            <a      class="btn btn-sm btn-success"
                                                    href="{{ route('pool.register', ['pool' => $pool->id]) }}" wire:navigate>Register, Entry Fee: {{$pool->entry_cost }}</a>
                                        @else
                                        <button class="btn btn-sm disabled">Registration Concluded</button>
                                        @endif
                                        
                                    @endcan
                                </td>
                                <td>{{ $pool->lives_per_person }}</td>
                                <td>{{ $pool->users->count() }}</td>

                                <td> {{ $start_date->diffForHumans() .' / '.$start_date->format('jS \o\f F, Y')}}</td>
                                <td>
                                    <a class="btn btn-sm" x-clipboard.raw="{{ route('pool.show', ['pool' => $pool->id]) }}">

                                        <svg className="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" strokeLinejoin="round" strokeWidth="2" d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z"/>
                                        </svg>
                                    </a>
                                </td>

                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                    {{ $pools->links() }}
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
    </x-app-layout>