<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ConsignmentRequest;
use Illuminate\Support\Facades\Crypt;

class ConsignRequest extends Component
{
    use WithPagination;

    public function requestDetails($id)
    {
        $encodedId = Crypt::encryptString($id);
        return redirect()->route('admin.consignment.details', ['id' => $encodedId]);
    }

    public function render()
    {
        $query = ConsignmentRequest::leftJoin('users', 'users.id', '=', 'consignment_requests.consignor_id')
            ->select('users.*', 'consignment_requests.*', 'users.name AS consignorName');

        return view('livewire.admin.consign-request', [
            'rows' => $query->paginate(5)
        ]);
    }
}
