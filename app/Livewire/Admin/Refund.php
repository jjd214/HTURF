<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\Refund as RefundModel;

class Refund extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url(history: true)]
    public $search;

    #[Url(history: true)]
    public $status;

    #[Url()]
    public $per_page = 5;

    public $selectedRefund = null;
    public $selectedInventory = null;

    public function selectRefund($refundId)
    {
        // Fetch the selected refund with inventory details
        $this->selectedRefund = RefundModel::with('inventory')->findOrFail($refundId);
        $this->selectedInventory = $this->selectedRefund->inventory; // Assuming 'inventory' is the relationship name
    }


    public function render()
    {
        $rows = RefundModel::search($this->search)
            ->filterStatus($this->status)
            ->leftJoin('inventories', 'refunds.inventory_id', '=', 'inventories.id') // Perform left join
            ->select('refunds.*', 'inventories.name AS inventory_name', 'inventories.brand AS inventory_brand', 'inventories.size AS inventory_size', 'inventories.color AS inventory_color') // Select refund and inventory details
            ->orderBy('refunds.id', 'asc')
            ->paginate($this->per_page);

        return view('livewire.admin.refund', [
            'rows' => $rows,
        ]);
    }
}
