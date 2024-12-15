<?php

namespace App\Livewire\User;

use App\Models\Admin;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Livewire\Component;
use Livewire\Attributes\On;

class Chat extends Component
{
    // protected $listeners = ['loadMessage' => 'loadNewMessage'];
    public $adminProfileHeader = '';
    public $messages = [];
    public $user;

    public $sender_id, $receiver_id, $chat_message;

    public function mount()
    {
        $this->user = User::findOrFail(auth('user')->id());
        $this->sender_id = auth('user')->id();

        $defaultSelectedAdmin = Admin::leftJoin('conversations', 'admins.id', '=', 'conversations.admin_id')
            ->select('admins.*', 'admins.id AS adminId', 'conversations.*')
            ->orderBy('conversations.updated_at', 'desc')
            ->first();

        if ($defaultSelectedAdmin) {
            $this->selectedAdmin($defaultSelectedAdmin->adminId);
        }
    }

    public function selectedAdmin($admin_id)
    {
        $this->adminProfileHeader = Admin::findOrFail($admin_id);
        $this->receiver_id = $admin_id;
        $this->conversations($admin_id);
    }

    #[On('load-message')]
    public function updateConversation($id)
    {
        $this->selectedAdmin($id);
    }

    public function conversations($adminId)
    {
        $conversation = Conversation::where('users_id', $this->sender_id)
            ->where('admin_id', $adminId)
            ->first();

        if ($conversation) {
            $this->messages = $conversation->messages()->get();
        } else {
            $this->messages = [];
        }
    }

    public function sendMessage()
    {
        if ($this->chat_message == '') return;

        $convo = Conversation::firstOrCreate(
            [
                'admin_id' => $this->receiver_id,
                'users_id' => $this->sender_id
            ]
        );

        $msg = $convo->messages()->create(
            [
                'sender_id' => $this->sender_id,
                'receiver_id' => $this->receiver_id,
                'message' => $this->chat_message
            ]
        );

        Conversation::where('id', $msg->conversation_id)->update(['updated_at' => now()]);

        $this->chat_message = '';
        $this->conversations($this->receiver_id);
    }

    public function render()
    {
        $admins = Admin::all();

        return view(
            'livewire.user.chat',
            [
                'admins' => $admins,
                'messages' => $this->messages
            ]
        );
    }
}
