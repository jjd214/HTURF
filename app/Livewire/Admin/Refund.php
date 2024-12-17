<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\Refund as RefundModel;
use App\Models\Inventory;
use Illuminate\Support\Facades\Log;


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
        $this->selectedRefund = RefundModel::with('inventory')->findOrFail($refundId);
        $this->selectedInventory = $this->selectedRefund->inventory;
    }

    public function restock()
    {
        if ($this->selectedRefund) {
            $inventory = Inventory::find($this->selectedInventory->id);
            $previousQty = $inventory->qty;

            $inventory->qty += $this->selectedRefund->quantity;
            $inventory->save();

            Log::info('Inventory restocked', [
                'inventory_id' => $inventory->id,
                'previous_qty' => $previousQty,
                'added_qty' => $this->selectedRefund->quantity,
                'updated_qty' => $inventory->qty,
            ]);

            $this->selectedRefund->status = 'Restocked';
            $this->selectedRefund->save();

            $this->dispatch('toast', type: 'success', message: 'Quantity has been successfully added back to inventory.');
        }
    }

    public function render()
    {
        return view('livewire.admin.refund', [
            'rows' => RefundModel::search($this->search)
                ->filterStatus($this->status)
                ->orderBy('id', 'desc')
                ->paginate($this->per_page),
        ]);
    }
}
