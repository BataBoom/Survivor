<x-layouts.email>

    <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800"></h1>
            <p class="text-gray-600">Week {{$week}}: on {{$pool->name}}</p>
            <p class="text-indigo-500">{{ $gameSummary['summary'] }}</p>
        </div>

        <!-- Main Content -->
        <div class="mb-6">
            <p class="mb-4">Well played {{$name}},</p>
            <p class="mb-4">Though there's still more work to be done.</p>
            <p class="mb-4">Click the button below to see what's next.</p>
            <p class="text-center">
                <a href="{{ route('pool.show', ['pool' => $pool->id]) }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded">Take me to the Arena</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-600">
            <p class="mb-2">Best regards,<br>The Survivor Team</p>
        </div>
    </div>

</x-layouts.email>