<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Url;

class Chat extends Component
{
    #[Url()]
    public $search_contact = '';

    public function render()
    {
        $users = User::when($this->search_contact, function ($query) {
            $query->where('name', 'like', '%' . $this->search_contact . '%')
                ->orWhere('username', 'like', '%' . $this->search_contact . '%');
        })->get();

        return view('livewire.admin.chat', ['users' => $users]);
    }
}
