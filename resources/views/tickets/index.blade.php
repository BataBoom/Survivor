<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Submit Ticket
        </h2>
    </x-slot>

    <div class="max-w-7xl">

        @if(Auth::user()->tickets->isNotEmpty())
        <div class="overflow-x-auto max-w-4xl mx-auto my-8">
                    <table class="table">
                        <!-- head -->
                        <thead>
                        <tr class="text-center">

                            <th>#</th>
                            <th>Subject</th>
                            <th>Replies</th>
                            <th>Answered</th>
                            <th>Resolved</th>
                            

                        </tr>
                        </thead>
                        <tbody>
                        @forelse(Auth::user()->tickets as $ticket)
                            <tr class="hover text-center">
                                <td class="text-xs"><a class="link hover:text-indigo-500" href="{{ route('support.show', ['ticket' => $ticket->id]) }}" wire:navigate>{{ $ticket->id }}<a></td>
                                <td><a class="link hover:text-indigo-500" href="{{ route('support.show', ['ticket' => $ticket->id]) }}" wire:navigate>{{ $ticket->subject }}</a></td>
                                <td>{{ $ticket->replies->count() }}</td>
                                <td @class(['text-success' => $ticket->answered, 'text-warning' => !$ticket->answered])>{{ $ticket->answered ? 'Yes' : 'No' }}</td>
                                <td @class(['text-green-500' => $ticket->resolved, 'text-warning' => !$ticket->resolved])>{{ $ticket->resolved ? 'Yes' : 'No' }}</td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            @endif


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