<x-layouts.email>

    <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
        <!-- Header -->
        <div class="text-center mb-6">
            @if($type == 'user')
            <h1 class="text-3xl font-bold text-gray-800">Welcome to {{ $pool->name }}, {{$user->name}}</h1>
            @elseif($type == 'admin')
            <h1 class="text-3xl font-bold text-gray-800">Welcome to the league! Your pool: {{ $pool->name }} has been setup, {{$user->name}}</h1>
            @endif
            <p class="text-gray-600">Outpick, Outplay, Outlast.</p>
        </div>

        <!-- Main Content -->
        <div class="mb-6">
            @if(is_null($pool->entry_cost))
            <p class="mb-4">Become the last player standing and take {{$pool->total_prize}}</p>
            @else
            <p class="mb-4">Become the last player standing and take {{$pool->total_prize}}, and counting! (New Entree's)</p>
            @endif

            <p class="mb-4">To get started, click the button below.</p>
            <p class="text-center">
                <a href="{{ route('pool.show', ['pool' => $pool->id]) }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded">Take me to the Arena</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-600">
            <p class="mb-2">Best regards,<br>The Survivor Team</p>
            <a style="color: #b0adc5; font-size: 12px;" class="text-xs" href="{{ route('unsubscribe', ['user' => $email]) }}">Unsubscribe?</a>
        </div>
    </div>

</x-layouts.email>