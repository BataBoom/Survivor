<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pool;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;
use Livewire\Attributes\On;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Events\NewChatroomMessageEvent;
class ChatRoom extends Component
{
    use Toast;

    public Pool $pool;

    public $messages;

    public $user;

    public $formMsg = '';

    public function mount()
    {
       // $this->pool = $pool;
        $this->messages = $this->pool->messages;
        //$this->user = Auth::user();
    }

    public function getListeners()
    {
        return [
            "echo-presence:game.chatroom.{$this->pool->id},NewChatroomMessageEvent" => 'updateChat',
        ];
    }

    public function save()
    {
        //$this->validate();

        $message = Message::Create([
            'pool_chat_id' => $this->pool->id,
            'from_id' => Auth::user()->id,
            'text' => $this->formMsg,
        ]);

        broadcast(new NewChatroomMessageEvent($message))->toOthers();

        $this->messages = $this->pool->messages;

    }

    public function updateChat()
    {
        $this->messages = $this->pool->messages;
    }


    public function delete(Message $msg)
    {
        if($msg->delete()) {
            $this->success('Message Deleted!');
            $this->messages = $this->pool->messages;
        } else {
            $this->error('Error');
        }
    }
    public function render()
    {
        return view('livewire.chat-room');
    }
}
