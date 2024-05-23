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
                        <thead>
                        <tr class="text-center">

                            <th>Pool Type</th>
                            <th>Name</th>
                            <th>Prize</th>
                            <th>Actions</th>
                            <th>Status</th>
                            <th>Max Lives</th>
                            <th>My Lives</th>

                        </tr>
                        </thead>
                        <tbody>
                        @forelse($myPools as $pool)
                            <tr class="hover text-center">
                                <td>{{ ucfirst($pool->pool->type) }}</td>
                                <td>{{ $pool->pool->name }}</td>
                                <td>{{ $pool->pool->prize_type }} @if($pool->pool->prize) |  {{ $pool->pool->prize }} @endif</td>
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

                                        @can('view', $pool->pool)
                                            <div>
                                                <a
                                                        class="btn btn-sm btn-warning"
                                                        href="{{ route('pool.leave', ['survivorregistration' => $pool->id]) }}">Leave Pool</a>
                                            </div>
                                        @endcan
                                    </div>
                                </td>
                                <td>{{ $pool->alive ? 'Alive' : 'Dead' }}</td>
                                <td>{{ $pool->pool->lives_per_person }}</td>
                                <td>{{ $pool->lives_count }}</td>
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
</x-app-layout>