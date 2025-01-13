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
    public $total_pending_items, $total_notified_items;
    public $total_pending_claims, $total_items_sold;

    public function mount()
    {
        $this->selling_items = Consignment::join('inventories', 'consignments.id', '=', 'inventories.consignment_id')
            ->where('consignments.consignor_id', auth('user')->id())
            ->where('inventories.qty', '!=', 0)
            ->count();
        $this->pending_consignments = ConsignmentRequest::where('consignor_id', auth('user')->id())->count();
        $this->total_payouts_claimed = $this->total_payouts_claimed();
        $this->total_expected_payouts = $this->total_expected_payouts();
        $this->total_pending_items = $this->total_pending_items();
        $this->total_notified_items = $this->total_notified_items();
        $this->total_pending_claims = $this->total_pending_claims();
        $this->total_items_sold = $this->total_items_sold();
    }

    public function total_items_sold()
    {
        return Payment::leftJoin('inventories', 'payments.inventory_id', 'inventories.id')
            ->leftJoin('consignments', 'inventories.consignment_id', 'consignments.id')
            ->where('consignments.consignor_id', auth('user')->id())
            ->where(function ($query) {
                $query->where('payments.status', 'Pending')
                    ->orWhere('payments.status', 'Notified');
            })
            ->sum('quantity');
    }

    public function total_pending_claims()
    {
        return Payment::leftJoin('inventories', 'payments.inventory_id', 'inventories.id')
            ->leftJoin('consignments', 'inventories.consignment_id', 'consignments.id')
            ->where('consignments.consignor_id', auth('user')->id())
            ->where(function ($query) {
                $query->where('payments.status', 'Pending')
                    ->orWhere('payments.status', 'Notified');
            })
            ->sum('payments.total');
    }


    public function total_pending_items()
    {
        return Payment::leftJoin('inventories', 'payments.inventory_id', 'inventories.id')
            ->leftJoin('consignments', 'inventories.consignment_id', 'consignments.id')
            ->where('consignments.consignor_id', auth('user')->id())
            ->where('payments.status', 'Pending')
            ->count();
    }

    public function total_notified_items()
    {
        return Payment::leftJoin('inventories', 'payments.inventory_id', 'inventories.id')
            ->leftJoin('consignments', 'inventories.consignment_id', 'consignments.id')
            ->where('consignments.consignor_id', auth('user')->id())
            ->where('payments.status', 'Notified')
            ->count();
    }

    public function total_payouts_claimed()
    {
        return Payment::leftJoin('inventories', 'payments.inventory_id', 'inventories.id')
            ->leftJoin('consignments', 'inventories.consignment_id', 'consignments.id')
            ->where('consignments.consignor_id', auth('user')->id())
            ->where('payments.status', 'Completed')
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
