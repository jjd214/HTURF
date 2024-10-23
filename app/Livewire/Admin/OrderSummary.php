<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Inventory as InventoryModel;
use App\Models\Transaction;
use App\Models\Consignment;
use App\Models\TransactionItem;

class OrderSummary extends Component
{
    public $orderSummary;

    protected $listeners = ['removeOrderSummary'];

    public function mount()
    {
        if (!session()->has('order_details')) {
            return redirect()->route('admin.sales.add-sales');
        }

        $this->orderSummary = session('order_summary');
    }

    public function removeOrderSummary()
    {
        session()->forget('order_summary');
    }

    public function store()
    {
        $orderSummary = session('order_summary');

        if ($orderSummary === null) {
            session()->flash('fail', [
                'type' => 'fail',
                'message' => 'Something went wrong, please try again.'
            ]);
            return redirect()->route('admin.sales.add-sales');
        }
        $totalItems = 0;
        $totalAmount = 0;
        $totalTax = 0;

        foreach ($orderSummary['cart'] as $productId => $cartItem) {
            $product = InventoryModel::find($productId);
            if ($product) {
                $totalItems += $cartItem['qty'];
                $totalAmount += $cartItem['total'];

                // Check if product is under consignment to calculate commission
                if ($product->consignment_id) {
                    $consignment = Consignment::find($product->consignment_id);
                    if ($consignment) {
                        $commission = $consignment->commission_percentage;
                        $productTax = ($cartItem['total'] * $commission) / 100;
                        $totalTax += $productTax;
                    }
                }

                // Create transaction item
                TransactionItem::create([
                    'code' => $orderSummary['transaction_code'],
                    'inventory_id' => $productId,
                    'qty' => $cartItem['qty'],
                    'total' => $cartItem['total']
                ]);

                // Deduct from available quantity
                $product->qty -= $cartItem['qty'];
                $product->save();
            }
        }

        // Create transaction record
        Transaction::create([
            'transaction_code' => $orderSummary['transaction_code'],
            'quantity_sold' => $totalItems,
            'total_amount' => $totalAmount,
            'amount_paid' => $orderSummary['amount_pay'],
            'amount_change' => $orderSummary['change'],
            'commission_amount' => $totalTax,
            'status' => 'Completed',
            'customer_name' => $orderSummary['customer_name']
        ]);

        // Clear the session
        session()->forget('order_summary');
        session()->forget('cart');
        session()->flash('success', [
            'type' => 'success',
            'message' => 'Transaction completed.'
        ]);
        return redirect()->route('admin.sales.add-sales');
    }

    public function render()
    {
        return view('livewire.admin.order-summary');
    }
}
