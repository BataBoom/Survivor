<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('My Pools') }}
        </h2>
    </x-slot>

    <div>
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
                        <h1 class="py-2 px-4 underline underline-offset-y-4 text-xl text-accent">Joined Pools</h1>
                        <thead>
                        <tr class="text-center">

                            <th>Pool Type</th>
                            <th>Name</th>
                            <th>Entry</th>
                             <!--<th>Prize</th>-->
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
                                {{--<td>{{ $pool->pool->guaranteed_prize }}</td>--}}
                                <td>{{ $pool->pool->total_prize }}</td>
                                <td>
                                    <div class="flex justify-around">
                                        @can('view', $pool->pool)
                                            <div class="flex justify-between">
                                                <div class="flex justify-start px-2">
                                                <a
                                                        class="btn btn-sm btn-success"
                                                        href="{{ route('pool.show', ['pool' => $pool->pool->id]) }}" wire:navigate>Open</a>
                                                </div>
                                                <div class="flex justify-end px-2">
                                                <a
                                                        class="btn btn-sm btn-primary"
                                                        href="{{ route('chat.show', ['pool' => $pool->pool->id]) }}" wire:navigate>Chat</a>
                                                </div>
                                            </div>
                                        @endcan

                                        @can('delete', $pool->pool)
                                            <div>
                                                <a
                                                        class="btn btn-sm btn-error"
                                                        href="{{ route('pool.destroy', ['pool' => $pool->pool->id]) }}" disabled>Delete</a>
                                            </div>
                                        @endcan
                                        {{--
                                            @if($pool->pool->entry_cost < 1)
                                                @can('view', $pool->pool)
                                                    <div>
                                                        <!---
                                                        <a
                                                                class="btn btn-sm btn-warning"
                                                                href="{{ route('pool.leave', ['survivorregistration' => $pool->id]) }}">Leave Pool</a>
                                                        -->  
                                                        <button class="btn btn-sm btn-warning" disabled>Leave Pool</button>
                                                    </div>
                                                @endcan
                                            @endif
                                    --}}
                                    </div>
                                </td>
                                <td @class(['text-green-500' => $pool->alive, 'text-red-500' => !$pool->alive])>{{ $pool->alive ? 'Alive' : 'Dead' }}</td>
                                <td>@if($pool->pool->type == 'survivor'){{ $pool->pool->lives_per_person }} @else N/A @endif</td>
                                <td>@if($pool->pool->type == 'survivor') {{ $pool->lives_count }}  @else N/A @endif</td>
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
                        @if(now()->lessThan(config('survivor.start_date')))
                        <a href="{{ route('pool.create') }}" class="btn btn-success w-1/2 mx-4" wire:navigate>Create Pool</a>
                        @endif

                        <a href="{{ route('pools.browse') }}" @class([
                        "btn btn-primary w-1/2 mx-4" => now()->lessThan(config('survivor.start_date')),
                        "btn btn-primary w-full mx-4" => now()->greaterThan(config('survivor.start_date')),
                        ]) wire:navigate>Browse Pools</a>
                    </div>


                </div>
            </div>
        </div>
    </div>

    @if($createdPools)
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col justify-center mt-16">
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <h1 class="py-2 px-4 underline underline-offset-y-4 text-xl text-accent">Created Pools</h1>
                        <thead>
                        <tr class="text-center">

                            <th>Pool Type</th>
                            <th>Name</th>
                            <th>Entry</th>
                            <th>Prize</th>
                            <th>Calc Prize</th>
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
                                <td>{{ $pool->guaranteed_prize }}</td>
                                <td>{{ $pool->total_prize }}</td>
                                <td>
                                    <div class="flex justify-around">
                                        @if(!$pool->IsSetupAttribute())
                                            <div>
                                                <a
                                                        class="btn btn-sm btn-primary"
                                                        href="{{ route('pool.setup', ['pool' => $pool->id]) }}" wire:navigate>Finish Setting Up</a>
                                            </div>
                                        @endif
                                        @if($pool->IsSetupAttribute())
                                            @can('view', $pool)
                                                    <div class="flex justify-between">
                                                        <div class="flex justify-start px-2">
                                                            <a
                                                                    class="btn btn-sm btn-success"
                                                                    href="{{ route('pool.show', ['pool' => $pool->id]) }}" wire:navigate>Open</a>
                                                        </div>
                                                        <div class="flex justify-end px-2">
                                                            <a
                                                                    class="btn btn-sm btn-primary"
                                                                    href="{{ route('chat.show', ['pool' => $pool->id]) }}" wire:navigate>Chat</a>
                                                        </div>

                                                    </div>
                                            @endcan


                                                    <div class="flex justify-between">
                                                        @can('delete', $pool)
                                                        <div class="flex justify-start px-2">
                                                        <a class="btn btn-sm btn-error"
                                                            href="{{ route('pool.destroy', ['pool' => $pool->id]) }}" disabled>Delete</a>
                                                        </div>
                                                        @endcan
                                                        @can('update', $pool)
                                                        <div class="flex justify-end px-1">
                                                            <a class="btn btn-sm btn-warning"
                                                                    href="{{ route('pool.edit', ['pool' => $pool->id]) }}" wire:navigate>Manage</a>
                                                        </div>
                                                        @endcan
                                                    </div>

                                        @endif
                                    </div>
                                </td>

                                <td>@if($pool->type == 'survivor'){{ $pool->lives_per_person }} @else N/A @endif</td>
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
        @endif
</x-app-layout>