<?php

namespace App\Livewire\User;

use App\Models\Admin;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Livewire\Component;

class Chat extends Component
{

    public function render()
    {

        return view('livewire.user.chat');
    }
}
