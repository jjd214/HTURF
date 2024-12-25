<?php

namespace App\Livewire\User;

use App\Models\Payment;
use Livewire\Component;

class Payments extends Component
{
    public function viewPaymentDetails($id)
    {
        dd($id);
    }

    public function render()
    {
        $payments = Payment::leftJoin('inventories', 'payments.inventory_id', '=', 'inventories.id')
            ->leftJoin('consignments', 'inventories.consignment_id', 'consignments.id')
            ->select('payments.payment_code', 'payments.quantity', 'payments.status', 'payments.date_of_payment', 'inventories.name', 'inventories.sku', 'inventories.id AS inventoryId')
            ->where('consignments.consignor_id', auth('user')->id())->get();

        return view('livewire.user.payments', [
            'rows' => $payments
        ]);
    }
}
