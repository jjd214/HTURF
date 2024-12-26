<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Consignment;
use App\Models\User;

class PaymentController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('back.pages.user.all-payments');
    }

    public function showPaymentDetails(Request $request, $payment_code)
    {
        $item_details = Payment::leftjoin('inventories', 'payments.inventory_id', '=', 'inventories.id')
            ->select('inventories.consignment_id', 'inventories.name', 'inventories.brand', 'inventories.sku', 'inventories.color', 'inventories.selling_price', 'inventories.picture', 'payments.*')
            ->where('payments.payment_code', $payment_code)
            ->first();

        $consignment_details = Consignment::where('id', $item_details['consignment_id'])->first();

        $consignor_details = User::where('id', $consignment_details['consignor_id'])->first();

        $payment_details = Payment::where('payment_code', $payment_code)->first();

        return view('back.pages.user.payment-details', [
            'itemDetails' => $item_details,
            'consignmentDetails' => $consignment_details,
            'consignorDetails' => $consignor_details,
            'paymentDetails' => $payment_details
        ]);
    }
}
