<?php

namespace App\Services;

use App\Livewire\Admin\Product;
use App\Models\Inventory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\ConsignmentRequest;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;

class AdminDataAnalysisServices
{
    public function getTotalExpenses()
    {
        return Expense::sum(DB::raw('purchase_price * qty'));
    }

    public function getTotalExpectedRevenue()
    {
        return Inventory::whereNull('consignment_id')
            ->sum(DB::raw('selling_price * qty'));
    }


    public function getTotalRevenue()
    {
        $totalRev = Transaction::leftJoin('transaction_items', 'transactions.transaction_code', '=', 'transaction_items.code')
            ->leftJoin('inventories', 'transaction_items.inventory_id', '=', 'inventories.id')
            ->whereNull('inventories.consignment_id') // Simplified syntax for checking NULL
            ->select(DB::raw('SUM(transaction_items.original_price * transaction_items.qty) as total_amount'))
            ->value('total_amount'); // Retrieve the summed value directly

        return $totalRev;
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

    public function getBestSellingProducts($monthAndYear)
    {
        $query = TransactionItem::leftJoin('inventories', 'transaction_items.inventory_id', '=', 'inventories.id')
            ->leftJoin('transactions', 'transaction_items.code', '=', 'transactions.transaction_code')
            ->where('inventories.consignment_id', NULL)
            ->select(
                'transaction_items.inventory_id',
                DB::raw('COALESCE(inventories.name, "Deleted Product") as name'),
                DB::raw('COALESCE(inventories.sku, "Unknown SKU") as sku'),
                DB::raw('SUM(transaction_items.qty * COALESCE(inventories.selling_price, 0)) as total_sales'),
                DB::raw('SUM(transaction_items.qty) as total_quantity_sold')
            );

        if (!empty($monthAndYear)) {
            [$month, $year] = explode(' ', $monthAndYear);
            $query->whereMonth('transactions.created_at', '=', date('m', strtotime($month)))
                ->whereYear('transactions.created_at', '=', $year);
        }

        return $query->groupBy('transaction_items.inventory_id', 'inventories.name', 'inventories.sku')
            ->orderByDesc('total_sales');
    }

    public function getInventoryTotalItems()
    {
        $totalItems = array(
            'storeItems' => Inventory::where('consignment_id', null)->count(),
            'consignItems' => Inventory::where('consignment_id', '!=', null)->count(),
            'sellingItems' => Inventory::where('visibility', '!=', 'private')->count(),
            'refundItems' => Refund::where('status', 'Refunded')->count()
        );

        return $totalItems;
    }

    public function totalSales($selectedDay)
    {
        $totalSales = 0;
        $totalItemsSold = 0;

        switch ($selectedDay) {
            case 'today':
                $transactions = Transaction::whereDate('created_at', now()->toDateString());
                break;

            case 'week':
                $transactions = Transaction::whereBetween('created_at', [
                    now()->startOfWeek()->toDateTimeString(),
                    now()->endOfWeek()->toDateTimeString()
                ]);
                break;

            case 'month':
                $transactions = Transaction::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                break;

            default:
                $transactions = null;
                break;
        }

        if ($transactions) {
            $totalSales = $transactions->sum('total_amount');
            $totalItemsSold = $transactions->sum('quantity_sold');
        }

        return [
            'totalSales' => $totalSales,
            'totalItemsSold' => $totalItemsSold,
        ];
    }
}
