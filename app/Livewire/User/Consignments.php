<?php

namespace App\Livewire\User;

use App\Models\ConsignmentRequest;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Consignments extends Component
{
    public function viewConsignmentStatus($id)
    {
        return redirect()->route('consignor.consignment.show-consignment-status-details', ['id' => $id]);
    }

    public function render()
    {
        $products = ConsignmentRequest::paginate(10)->where('consignor_id', auth('user')->id());

        return view('livewire.user.consignments', compact('products'));
    }
}
