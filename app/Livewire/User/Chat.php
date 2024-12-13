<?php

namespace App\Livewire\User;

use App\Models\Admin;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Livewire\Component;

class Chat extends Component
{
    public $sender_id, $receiver_id, $conversation_id, $message;

    public function mount()
    {
        $user = User::findOrFail(auth('user')->id());
        $admin = Admin::all()->first();
        $conversation = $user->conversations->first();
        $this->sender_id = $user->id;
        $this->receiver_id = $admin->id;
        $this->conversation_id = $conversation->id;
    }

    public function sendMessage()
    {
        if ($this->message == '') return;

        $conversation = Conversation::firstOrCreate([
            'users_id' => $this->sender_id,
            'admin_id' => $this->receiver_id,
        ]);

        $msg = $conversation->messages()->create([
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'message' => $this->message,
        ]);

        Conversation::where('id', $msg->conversation_id)->update(['updated_at' => now()]);

        $this->message = '';
    }

    public function render()
    {
        $admin = Admin::all()->first();
        $user = User::find(auth('user')->id());
        $conversation = $user->conversations->first();


        if ($conversation) {
            $messages = Message::where('conversation_id', $conversation->id)->get();
        }

        $this->conversation_id = $conversation->id;

        return view('livewire.user.chat', compact('admin', 'messages'));
    }
}
