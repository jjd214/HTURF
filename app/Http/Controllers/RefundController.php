<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;

class RefundController extends Controller
{
    public function index()
    {
        return view('back.pages.admin.all-refunds');
    }

    public function show($transaction_code)
    {
        $transactionItems = Transaction::where('transaction_code', $transaction_code)->first();

        $rows = TransactionItem::leftJoin('inventories', 'transaction_items.inventory_id', '=', 'inventories.id')
            ->select('inventories.name', 'inventories.picture', 'inventories.selling_price', 'inventories.qty', 'transaction_items.*')
            ->where('transaction_items.code', $transaction_code)
            ->get();

        $customer_name = $transactionItems['customer_name'];

        return view(
            'back.pages.admin.add-refund',
            [
                'rows' => $rows,
                'customer_name' => $customer_name,
                'transaction_code' => $transaction_code
            ]
        );
    }
}
