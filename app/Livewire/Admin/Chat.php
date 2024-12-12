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
    #[Url()]
    public $search_contact = '';
    public $selectedUser;
    public $conversation;
    public $message = '';
    public $sender_id, $receiver_id;
    public $conversation_messages = [];

    public $admin;

    public function mount()
    {
        $this->admin = Admin::findOrFail(auth('admin')->id());
        $this->sender_id = auth('admin')->id();
        $firstUser = User::leftJoin('conversations', 'users.id', '=', 'conversations.users_id')
            ->where('conversations.admin_id', $this->sender_id)
            ->select('users.*', 'users.id AS userId', 'conversations.*')
            ->orderBy('conversations.updated_at', 'desc')
            ->first();

        if ($firstUser) {
            $this->selectUser($firstUser->userId);
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->receiver_id = $userId;
        $this->loadConversation();
    }

    public function loadConversation()
    {
        $conversation = Conversation::where('users_id', $this->receiver_id)
            ->where('admin_id', $this->sender_id)
            ->first();

        if ($conversation) {
            $this->conversation = $conversation;
            $this->conversation_messages = $conversation->messages()->get();
        } else {
            $this->conversation = null;
            $this->conversation_messages = [];
        }
    }

    public function sendMessage()
    {
        $conversation = Conversation::firstOrCreate([
            'users_id' => $this->receiver_id,
            'admin_id' => $this->sender_id,
        ]);

        $msg = $conversation->messages()->create([
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'message' => $this->message,
        ]);

        Conversation::where('id', $msg->conversation_id)->update(['updated_at' => now()]);

        $this->message = '';
        $this->loadConversation();
    }

    public function render()
    {
        $users = User::leftJoin('conversations', 'users.id', '=', 'conversations.users_id')
            ->where('conversations.admin_id', auth('admin')->id())
            ->select('users.*', 'users.id AS userId', 'conversations.*')
            ->orderBy('conversations.updated_at', 'desc')
            ->get();

        return view('livewire.admin.chat', [
            'users' => $users,
        ]);
    }
}
