<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Payment as PaymentModel;
use Illuminate\Support\Facades\DB;

class Payments extends Component
{
    public function showPaymentForm($id)
    {
        $payment_code = DB::table('payments')
            ->where('id', $id)
            ->value('payment_code');

        return redirect()->route('admin.payment.details', ['payment_code' => $payment_code]);
    }


    public function render()
    {
        $query = PaymentModel::leftJoin('inventories', 'payments.inventory_id', '=', 'inventories.id')
            ->leftJoin('consignments', 'inventories.consignment_id', '=', 'consignments.id')
            ->leftJoin('users', 'consignments.consignor_id', '=', 'users.id')
            ->select(
                'payments.*',
                'inventories.name as inventory_name',
                'inventories.brand',
                'inventories.size',
                'inventories.color',
                'inventories.selling_price',
                'inventories.picture',
                'consignments.commission_percentage',
                'consignments.start_date',
                'consignments.expiry_date',
                'users.name as consignor_name',
                'users.username',
                'users.email'
            )
            ->orderBy('payments.id', 'desc')
            ->get();

        return view(
            'livewire.admin.payments',
            [
                'rows' => $query
            ]
        );
    }
}
