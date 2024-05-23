<x-layouts.survivor>

    <x-slot:title>{{ $type.' '.$pool->name }} | Forbidden </x-slot:title>
 <x-slot:header>
     <h1>You're forbidden from accessing {{$type}} pool: {{$pool->name}}</h1>
 </x-slot:header>


    <div class="py-12">
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
                                    <a
                                            class="btn btn-sm btn-success"
                                            href="{{ route('pool.show', ['pool' => $pool->id]) }}">Register</a>
                                </td>
                                <td>{{$hasStarted ? 'In progress' : 'Registering' }}</td>
                                <td>{{ $pool->lives_per_person }}</td>
                                <td> {{ $startDate->diffForHumans() .' / '.$startDate->format('jS \o\f F, Y')}}</td>
                                <td>{{ $pool->users->count() }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="column pt-6 px-8">

                    <div class="flex justify-evenly">
                        <a class="btn btn-primary w-1/2 mx-4">Browse Pools</a>
                        <a class="btn btn-success w-1/2 mx-4">Create Pools</a>
                    </div>


                </div>
            </div>
        </div>
    </div>

</x-layouts.survivor>