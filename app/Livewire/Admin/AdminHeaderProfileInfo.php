<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminHeaderProfileInfo extends Component
{
    public $admin;

    protected $listeners = [
        'updateAdminHeaderInfo' => '$refresh'
    ];

    public function mount()
    {
        if (Auth::guard('admin')->check()) {
            $this->admin = Admin::findOrFail(auth()->id());
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-header-profile-info');
    }
}
