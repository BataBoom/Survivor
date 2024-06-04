<div id="chat-container" class="lg:max-w-2/3 max-h-screen my-4">
    <div class="p-4 overflow-hidden">
        @forelse($messages as $msg)
            <div @class(['chat', 'chat-start' => Auth::user()->is($msg->from), 'chat-end' => $msg->from->isNot(Auth::user())])>
                <div class="avatar chat-image">
                    <div class="w-10 rounded-full">
                        <img src="{{ $msg->from->avatar }}" />
                    </div>
                </div>
                <div class="chat-header">
                    <div class="flex justify-between">
                    {{$msg->from->name}}
                        <span @class(['text-green-500' => $msg->is_alive, 'text-red-500' => !$msg->is_alive])>{{ $msg->is_alive ? 'Alive' : 'Dead' }}</span>
                    </div>

                        <div class="flex justify-between">
                    <time class="text-xs opacity-50 px-2">{{ $msg->created_at?->diffForHumans() }}</time>
                            @if(Auth::user()->is($msg->from) && $msg->created_at->greaterThan(now()->subMinutes(5)))
                                <button wire:click="delete('{{$msg->id}}')" class="btn btn-xs btn-error">X</button>
                            @elseif(Auth::user()->isAdmin())
                                <button wire:click="delete('{{$msg->id}}')" class="btn btn-xs btn-error">X</button>
                            @endif
                        </div>

                </div>
                <div class="chat-bubble">{{ $msg->text }}</div>
            </div>
        @empty
        @endforelse
    </div>
        <div class="absolute bottom-2 w-full lg:w-2/3 h-24 py-4 px-4 border border-black">
            <form wire:submit="save">
                <textarea wire:model="formMsg" class="textarea textarea-info w-full" placeholder="Your Message.."></textarea>
                <button type="submit" class="btn btn-primary w-full mt-2">Submit</button>
            </form>
        </div>
</div>
