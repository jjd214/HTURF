<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminHeaderProfileInfo extends Component
{
    public $admin;
    public $user;

    protected $listeners = [
        'updateAdminHeaderInfo' => '$refresh'
    ];

    public function mount()
    {
        if (Auth::guard('admin')->check()) {
            $this->admin = Admin::findOrFail(auth('admin')->id());
        }
        if (Auth::guard('user')->check()) {
            $this->user = User::findOrFail(auth('user')->id());
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-header-profile-info');
    }
}
