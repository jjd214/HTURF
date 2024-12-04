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

        $conversation->messages()->create([
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'message' => $this->message,
        ]);

        $this->message = '';
        $this->loadConversation();
    }

    public function render()
    {
        $users = User::query()
            ->with(['conversations' => function ($query) {
                $query->with('messages')
                    ->orderByDesc(
                        Message::select('created_at')
                            ->whereColumn('conversations.id', 'messages.conversation_id')
                            ->latest()
                            ->limit(1)
                    );
            }])
            ->when($this->search_contact, function ($query) {
                $query->where('name', 'like', "%{$this->search_contact}%")
                    ->orWhere('username', 'like', "%{$this->search_contact}%");
            })
            ->get();


        return view('livewire.admin.chat', [
            'users' => $users,
        ]);
    }
}