<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;

class UserProfile extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';

    protected $queryString = ['tab' => ['keep' => true]];

    public $name, $username, $email, $phone, $address;

    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->tab = request()->tab ? request()->tab : $this->tabname;

        $consignor = User::findOrFail(auth('user')->id());
        $this->name = $consignor->name;
        $this->username = $consignor->username;
        $this->email = $consignor->email;
        $this->phone = $consignor->phone;
        $this->address = $consignor->address;
    }

    public function updateUserPersonalDetails()
    {
        $this->validate([
            'name' => 'required|min:5',
            'username' => 'nullable|min:5|unique:users,username,' . auth('user')->id(),
        ]);
        $consignor = User::findOrFail(auth('user')->id());
        $consignor->name = $this->name;
        $consignor->username = $this->username;
        // $consignor->phone = $this->phone;
        // $consignor->address = $this->address;
        $update = $consignor->save();

        if ($update) {
            $this->dispatch('updateAdminHeaderInfo');
            $this->dispatch('toast', type: 'success', message: 'Personal details updated successfully.');
        } else {
            $this->dispatch('toast', type: 'error', message: 'Something went wrong.');
        }
    }

    public function render()
    {
        return view('livewire.user.user-profile', [
            'user' => User::findOrFail(auth('user')->id())
        ]);
    }
}
