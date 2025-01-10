<?php

namespace App\Livewire\User;

use App\Models\Consignment;
use App\Models\ConsignmentRequest;
use App\Models\Payment;
use App\Models\Inventory;
use Livewire\Component;

class Dashboard extends Component
{
    public $selling_items, $pending_consignments;
    public $total_payouts_claimed, $total_expected_payouts;

    public function mount()
    {
        $this->selling_items = Consignment::where('consignor_id', auth('user')->id())->count();
        $this->pending_consignments = ConsignmentRequest::where('consignor_id', auth('user')->id())->count();
        $this->total_payouts_claimed = $this->total_payouts_claimed();
        $this->total_expected_payouts = $this->total_expected_payouts();
    }

    public function total_payouts_claimed()
    {
        return Payment::leftJoin('inventories', 'payments.inventory_id', 'inventories.id')
            ->leftJoin('consignments', 'inventories.consignment_id', 'consignments.id')
            ->where('consignments.consignor_id', auth('user')->id())
            ->sum('payments.total');
    }

    public function total_expected_payouts()
    {
        $data = Inventory::leftJoin('consignments', 'inventories.consignment_id', '=', 'consignments.id')
            ->where('consignments.consignor_id', auth('user')->id())
            ->get(['inventories.selling_price', 'inventories.qty', 'consignments.commission_percentage']);

        $payout_price = 0;

        foreach ($data as $item) {
            $totalPrice = $item->selling_price * $item->qty;
            $commission = ($totalPrice * $item->commission_percentage) / 100;
            $payout_price += $totalPrice - $commission;
        }

        return $payout_price;
    }


    public function render()
    {
        return view('livewire.user.dashboard');
    }
}
