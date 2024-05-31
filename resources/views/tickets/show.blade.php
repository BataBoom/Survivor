<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Ticket#{{ $ticket->id}}
        </h2>
    </x-slot>

    <div class="max-w-7xl">
            <div class="flex justify-end">
                @if(Auth::user()->is($ticket->user))
                <a href="{{ route('ticket.destroy', ['ticket' => $ticket->id]) }}" class="btn btn-error mx-4">
                    Trash Ticket
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </a>
                @endif
            </div>
            <div class="flex justify-center">
                <h2 class="text-lg text-primary underline"> Subject: {{$ticket->subject}}</h2>
            </div>


                <div class="flex flex-col justify-center mt-6">


                    <div class="px-4">
                    @forelse($ticket->replies as $msg)
                        <div @class(['chat', 'chat-start' => Auth::user()->is($ticket->user), 'chat-end' => $msg->user->isNot(Auth::user())])>

                        <div class="chat-header">
                            {{$msg->user->name}}
                            <time class="text-xs opacity-50">{{ $msg->created_at?->diffForHumans() }}</time>
                        </div>
                        <div class="chat-bubble">{{ $msg->message }}</div>
                        </div>

                    @empty
                    @endforelse

                </div>
                </div>

<div class="my-4">
                        <form action="{{ route('ticket.store', ['ticket' => $ticket->id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
                            @csrf
                            <div class="flex flex-col gap-4">
                                <div>
                                    <textarea class="textarea textarea-primary w-full input-bordered input-primary" placeholder="Here's your pen" name="message" value="{{ old('message') }}"></textarea>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-block">Reply</button>
                                </div>
                        </form>

    </div>
    </div>
</x-app-layout>