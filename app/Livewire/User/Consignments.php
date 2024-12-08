<?php

namespace App\Livewire\User;

use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Consignments extends Component
{
    public function render()
    {
        $products = Inventory::leftJoin('consignments', 'inventories.consignment_id', '=', 'consignments.id')
            ->where('consignments.consignor_id', auth('user')->id());
        return view('livewire.user.consignments', compact('products'));
    }
}
