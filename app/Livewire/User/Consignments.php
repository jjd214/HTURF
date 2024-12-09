<?php

namespace App\Livewire\User;

use App\Models\ConsignmentRequest;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;


class Consignments extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function viewConsignmentStatus($id)
    {
        return redirect()->route('consignor.consignment.show-consignment-status-details', ['id' => $id]);
    }

    public function render()
    {
        $products = ConsignmentRequest::where('consignor_id', auth('user')->id())
            ->paginate(10);

        return view('livewire.user.consignments', compact('products'));
    }
}
