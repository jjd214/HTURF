<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionItem;

class SalesController extends Controller
{
    public function show($transaction_code)
    {
        $transactionItems = TransactionItem::where('code', $transaction_code)->get();
        return view('back.pages.admin.transaction-details', compact('transactionItems'));
    }
}
