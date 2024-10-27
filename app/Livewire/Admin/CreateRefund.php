<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\TransactionItem;
use App\Models\Transaction;

class CreateRefund extends Component
{
    public $customer_name = '';
    public $items = [];
    public $selectedItem;
    public $quantity;
    public $reasonForRefund = '';
    public $transid = "";

    public function mount($transaction_code)
    {
        $transaction = Transaction::where('transaction_code', $transaction_code)->first();
        $this->customer_name = $transaction ? $transaction->customer_name : '';
        $this->transid = $transaction_code;
    }

    public function updatedSelectedItem($value)
    {
        $consignor = TransactionItem::where('inventory_id', $value)
            ->where('code', $this->transid)
            ->first();
        if ($consignor) {
            $this->quantity = $consignor->qty;
        } else {
            $this->quantity = 0;
        }
    }

    public function render()
    {
        return view('livewire.admin.create-refund', [
            'rows' => TransactionItem::leftJoin('inventories', 'transaction_items.inventory_id', '=', 'inventories.id')
                ->select('inventories.id', 'inventories.name', 'inventories.picture', 'inventories.selling_price', 'inventories.qty', 'transaction_items.*')
                ->where('transaction_items.code', $this->transid)
                ->get()
        ]);
    }
}
