<x-layouts.email>

    <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Welcome to NBZ NFL Survivor</h1>
        </div>

        <!-- Main Content -->
        <div class="mb-6">
            <p class="mb-4">Hi {{$name}},</p>
            <p class="mb-4">We've received your request to join the league. Your request has been accepted. You've been automatially assigned to Bravo. Good luck!
            <p class="text-center">
                <a href="https://survivor.nbz.one" class="button button-success">Take me to the arena</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-600">
            <p class="mb-2">Best regards,<br>The Survivor Team</p>
            <a style="color: #b0adc5; font-size: 12px;" class="text-xs" href="{{ route('unsubscribe', ['user' => $email]) }}">Unsubscribe?</a>
        </div>
    </div>

</x-layouts.email>