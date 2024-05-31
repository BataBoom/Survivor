<x-layouts.email>

    <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">New Pool Created!</h1>
            <p class="text-gray-600">Outpick, Outplay, Outlast.</p>
            <p class="text-gray-600">Survive & become the 3rd NBZ NFL Survivor and take 0.01 BTC. Free to play! </p>
        </div>

        <!-- Main Content -->
        <div class="mb-6">
            <p class="mb-4">Hi {{$name}},</p>
            <p class="mb-4">We've received your request to join the league. You're in!</p>
            <p class="mb-4">To get started, please verify your email address by clicking the link below:</p>
            <p class="text-center">
                <a href="#" class="inline-block bg-blue-500 text-white py-2 px-4 rounded">Verify Email</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-600">
            <p class="mb-2">Best regards,<br>The Survivor Team</p>
        </div>
    </div>

</x-layouts.email>