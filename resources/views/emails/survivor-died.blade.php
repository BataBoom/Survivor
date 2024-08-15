<x-layouts.email>

    <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">

        <!-- Main Content -->
        <div class="mb-6">
            <p class="mb-4">Hi {{$name}},</p>
            <p class="text-gray-600">Week {{$week}}: on {{$pool->name}}</p>
            <p class="text-indigo-500">{{ $gameSummary['summary'] }}</p>
            <p class="mb-4">{{ $gg }}</p>
            <p class="mb-4">Click the button below to practice on Pick'em</p>
            <p class="text-center">
                <a href="{{ $pickemLink }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded">Take me to Pick'em</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-600">
            <p class="mb-2">Best regards,<br>The Survivor Team</p>
        </div>
    </div>

</x-layouts.email>