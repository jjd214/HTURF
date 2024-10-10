<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Sale;

class PointOfSalesController extends Controller
{
    public function addSales()
    {
        $data = [
            'pageTitle' => 'New sales',
            'rows' => Product::all()
        ];

        return view('back.pages.admin.add-sales', $data);
    }

    public function allSales()
    {
        $data = [
            'pageTitle' => 'Sales history'
        ];

        return view('back.pages.admin.all-sales', $data);
    }

    public function showReceipt($id)
    {
        $transaction = [];

        $sale = Sale::find($id);

        if ($sale) {
            $transaction = Transaction::where('transaction_code', $sale->transaction_code)
                ->join('products', 'transactions.product_id', '=', 'products.id')
                ->select('transactions.*', 'products.name as product_name', 'products.selling_price as product_price')
                ->get();

            // $product = Product::where('id', $transaction->product_id);
        }

        return view('back.pages.admin.receipt', [
            'rows' => $transaction,
            'sale' => $sale
        ]);
    }
}
