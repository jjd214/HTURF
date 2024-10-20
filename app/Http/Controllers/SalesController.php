<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionItem;
use App\Models\Transaction;

class SalesController extends Controller
{
    public function show($transaction_code)
    {
        $transactionItems = Transaction::where('transaction_code', $transaction_code)->first();

        $rows = TransactionItem::leftJoin('inventories', 'transaction_items.inventory_id', '=', 'inventories.id')
            ->select('inventories.name', 'inventories.picture', 'inventories.selling_price', 'transaction_items.*')
            ->where('transaction_items.code', $transaction_code)
            ->get();

        return view('back.pages.admin.transaction-details', [
            'transactionItems' => $transactionItems,
            'rows' => $rows
        ]);
    }
}
