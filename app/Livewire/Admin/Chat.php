<?php

namespace App\Livewire\Admin;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Admin;

class Chat extends Component
{

    public $userProfileHeader = '';
    public $messages = [];
    public $admin;

    #[Url(history: true)]
    public $search_contact = '';

    public $sender_id, $receiver_id, $chat_message;

    public function mount()
    {
        $this->admin = Admin::findOrFail(auth('admin')->id());
        $this->sender_id = auth('admin')->id();

        $defaultSelectedUser =  User::leftJoin('conversations', 'users.id', '=', 'conversations.users_id')
            ->select('users.*', 'users.id AS userId', 'conversations.*')
            ->orderBy('conversations.updated_at', 'desc')
            ->first();

        if ($defaultSelectedUser) {
            $this->selectedUser($defaultSelectedUser->userId);
        }
    }

    public function selectedUser($user_id)
    {
        $this->userProfileHeader = User::findOrFail($user_id);
        $this->receiver_id = $user_id;
        $this->conversations($user_id);
    }

    public function conversations($userId)
    {
        $conversation = Conversation::where('admin_id', $this->sender_id)
            ->where('users_id', $userId)
            ->first();

        if ($conversation) {
            $this->messages = $conversation->messages()->orderBy('id', 'desc')->get();
        } else {
            $this->messages = [];
        }
    }

    public function sendMessage()
    {
        if ($this->chat_message == '') return;

        $convo = Conversation::firstOrCreate(
            [
                'admin_id' => $this->sender_id,
                'users_id' => $this->receiver_id
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
        // $this->dispatch('load-message', id: $this->sender_id);
        $this->conversations($this->receiver_id);
    }

    public function refreshMessage()
    {
        if ($this->receiver_id) {
            $this->conversations($this->receiver_id);
        }
    }

    public function render()
    {
        $query = User::leftJoin('conversations', 'users.id', '=', 'conversations.users_id')
            ->select('users.*', 'users.id AS userId', 'conversations.*')
            ->orderBy('conversations.updated_at', 'desc');

        if (!empty($this->search_contact)) {
            $query->where(function ($q) {
                $q->where('users.name', 'like', '%' . $this->search_contact . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search_contact . '%');
            });
        }

        $users = $query->get();

        return view('livewire.admin.chat', [
            'users' => $users,
            'messages' => $this->messages
        ]);
    }
}
