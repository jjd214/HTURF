<?php

namespace App\Services;

use App\Livewire\Admin\Product;
use App\Models\Inventory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\ConsignmentRequest;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;

class AdminDataAnalysisServices
{
    public function getTotalExpenses()
    {
        return Inventory::whereNull('consignment_id')->sum('purchase_price');
    }

    public function getTotalExpectedRevenue()
    {
        return Inventory::sum('selling_price');
    }

    public function getTotalRevenue()
    {
        return Transaction::sum('total_amount');
    }

    public function getTotalCommissionFee()
    {
        return Transaction::sum('commission_amount');
    }

    public function getTotalConsignors()
    {
        return User::where(function ($query) {
            $query->where('verified', 1)
                ->orWhereNotNull('google_id');
        })->count();
    }

    public function getTotalPendingConsignmentRequest()
    {
        return ConsignmentRequest::where('status', 'Pending')->count();
    }

    public function getTotalPendingPayments()
    {
        return Payment::where('status', 'Pending')->count();
    }

    public function getBestSellingProducts()
    {
        $best_selling_products = TransactionItem::leftJoin('inventories', 'transaction_items.inventory_id', '=', 'inventories.id')
            ->select(
                'inventories.id',
                'inventories.name',
                'inventories.sku',
                DB::raw('SUM(transaction_items.qty * inventories.selling_price) as total_sales'),  // Total sales calculation
                DB::raw('SUM(transaction_items.qty) as total_quantity_sold')  // Total quantity sold calculation
            )
            ->groupBy('inventories.id', 'inventories.name', 'inventories.sku')
            ->orderByDesc('total_sales')  // Order by total sales
            ->limit(5)
            ->get();

        return $best_selling_products;
    }



    public function getInventoryTotalItems()
    {
        $totalItems = array(
            'storeItems' => Inventory::where('consignment_id', null)->count(),
            'consignItems' => Inventory::where('consignment_id', '!=', null)->count(),
            'sellingItems' => Inventory::where('visibility', '!=', 'private')->count(),
            'refundItems' => Refund::all()->count()
        );

        return $totalItems;
    }
}
