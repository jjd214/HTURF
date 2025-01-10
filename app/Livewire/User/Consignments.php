<?php

namespace App\Livewire\User;

use App\Models\ConsignmentRequest;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;


class Consignments extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url(history: true)]
    public $search = '';
    #[Url('status', history: true)]
    public $visibility = '';
    #[Url()]
    public $per_page = 10;

    public function viewConsignment($id)
    {
        return redirect()->route('consignor.consignment.show-consignment_details', ['id' => $id]);
    }

    public function viewConsignmentStatus($id)
    {
        return redirect()->route('consignor.consignment.show-consignment-status-details', ['id' => $id]);
    }

    public function render()
    {
        $products = ConsignmentRequest::where('consignor_id', auth('user')->id())
            ->paginate(10);

        $inventories = Inventory::leftJoin('consignments', 'inventories.consignment_id', '=', 'consignments.id')
            ->select('inventories.*', 'consignments.*')
            ->where('consignments.consignor_id', auth('user')->id())
            ->where('inventories.qty', '!=', 0)
            ->when($this->search, function ($query) {
                $query->where('inventories.name', 'like', '%' . $this->search . '%');
            })
            ->when($this->visibility, function ($query) {
                $query->where('inventories.visibility', $this->visibility);
            })
            ->paginate($this->per_page);

        return view('livewire.user.consignments', compact('products', 'inventories'));
    }
}
