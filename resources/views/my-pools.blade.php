<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('My Pools') }}
        </h2>
    </x-slot>

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
            <div class="flex flex-col justify-center mt-16">
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <h1>Joined Pools</h1>
                        <thead>
                        <tr class="text-center">

                            <th>Pool Type</th>
                            <th>Name</th>
                            <th>Entry</th>
                            <th>Prize</th>
                            <th>Actions</th>
                            <th>Status</th>
                            <th>Max Lives</th>
                            <th>My Lives</th>
                            <th>Registered Players</th>
                            <th>Copy</th>

                        </tr>
                        </thead>
                        <tbody>
                        @forelse($myPools as $pool)
                            <tr class="hover text-center">
                                <td>{{ ucfirst($pool->pool->type) }}</td>
                                <td>{{ $pool->pool->name }}</td>
                                <td>@if($pool->pool->entry_cost) ${{$pool->pool->entry_cost}} @else FREE @endif</td>
                                <td>@if($pool->pool->guaranteed_prize > 1) {{ $pool->pool->guaranteed_prize }} USD (in crypto) @else N/A @endif</td>
                                <td>
                                    <div class="flex justify-around">
                                        @can('view', $pool->pool)
                                            <div>
                                                <a
                                                        class="btn btn-sm btn-success"
                                                        href="{{ route('pool.show', ['pool' => $pool->pool->id]) }}" wire:navigate>Open</a>
                                            </div>
                                        @endcan

                                        @can('delete', $pool->pool)
                                            <div>
                                                <a
                                                        class="btn btn-sm btn-error"
                                                        href="{{ route('pool.destroy', ['pool' => $pool->pool->id]) }}">Delete</a>
                                            </div>
                                        @endcan
                                    @if($pool->pool->entry_cost < 1)
                                        @can('view', $pool->pool)
                                            <div>
                                                <a
                                                        class="btn btn-sm btn-warning"
                                                        href="{{ route('pool.leave', ['survivorregistration' => $pool->id]) }}">Leave Pool</a>
                                            </div>
                                        @endcan
                                    @endif
                                    </div>
                                </td>
                                <td>{{ $pool->alive ? 'Alive' : 'Dead' }}</td>
                                <td>{{ $pool->pool->lives_per_person }}</td>
                                <td>{{ $pool->lives_count }}</td>
                                <td>{{ $pool->pool->contenders->count() }}</td>
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
                <div class="column pt-6 px-8">

                    <div class="flex justify-evenly">
                        <a href="{{ route('pool.create') }}" class="btn btn-success w-1/2 mx-4" wire:navigate>Create Pool</a>
                        <a href="{{ route('pools.browse') }}" class="btn btn-primary w-1/2 mx-4" wire:navigate>Browse Pools</a>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col justify-center mt-16">
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <h1>Created Pools</h1>
                        <thead>
                        <tr class="text-center">

                            <th>Pool Type</th>
                            <th>Name</th>
                            <th>Entry</th>
                            <th>Prize</th>
                            <th>Actions</th>
                            <th>Max Lives</th>
                            <th>Registered Players</th>
                            <th>Copy</th>

                        </tr>
                        </thead>
                        <tbody>
                        @forelse($createdPools as $pool)
                            <tr class="hover text-center">
                                <td>{{ ucfirst($pool->type) }}</td>
                                <td>{{ $pool->name }}</td>
                                <td>@if($pool->entry_cost) ${{$pool->entry_cost}} @else FREE @endif</td>
                                <td>@if($pool->guaranteed_prize > 1) {{ $pool->guaranteed_prize }} USD (in crypto) @else N/A @endif</td>
                                <td>
                                    <div class="flex justify-around">
                                        @if(!$pool->IsSetupAttribute())
                                            <div>
                                                <a
                                                        class="btn btn-sm btn-success"
                                                        href="{{ route('pool.setup', ['pool' => $pool->id]) }}" wire:navigate>Finish Setting Up</a>
                                            </div>
                                        @endif
                                        @if($pool->IsSetupAttribute())
                                            @can('view', $pool)
                                                <div>
                                                    <a
                                                            class="btn btn-sm btn-success"
                                                            href="{{ route('pool.show', ['pool' => $pool->id]) }}" wire:navigate>Open</a>
                                                </div>
                                            @endcan

                                            @can('delete', $pool)
                                                <div>
                                                    <a
                                                            class="btn btn-sm btn-error"
                                                            href="{{ route('pool.destroy', ['pool' => $pool->id]) }}">Delete</a>
                                                </div>
                                            @endcan
                                        @endif
                                    </div>
                                </td>

                                <td>{{ $pool->lives_per_person }}</td>
                                <td>{{ $pool->contenders->count() }}</td>
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
</x-app-layout>