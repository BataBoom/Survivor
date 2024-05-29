<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Submit Ticket
        </h2>
    </x-slot>

    <div class="max-w-7xl">
        <form action="{{ route('ticket.create') }}" method="POST" class="max-w-4xl mx-auto p-6 rounded-lg shadow-md">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" value="{{ Auth::user()->name }}" name="name" class="mt-1 block input input-bordered input-primary w-full sm:text-sm" disabled>
                </div>

                <div>
                    <label for="accessibility" class="block text-sm font-medium text-gray-700">Attach Payment</label>
                    <select name="payment" class="select select-primary w-full max-w-xs">

                        <option selected>None</option>
                        @forelse($payments as $payment)
                            <option value="{{ $payment->payment_id}}">{{ $payment->payment_id }}</option>
                        @empty
                        @endforelse

                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" placeholder="What's this about?" class="mt-1 block input input-bordered input-primary w-full sm:text-sm">
                </div>

                <div class="md:col-span-2">
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea class="textarea textarea-primary w-full input-bordered input-primary" placeholder="Here's your pen" name="message" value="{{ old('message') }}"></textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="btn btn-primary btn-block">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>