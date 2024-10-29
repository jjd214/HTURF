<?php

namespace App\Livewire\Admin;

use App\Models\Inventory as InventoryModel;
use App\Models\Refund;
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
    public $size;
    public $price;
    public $transid = "";
    public $item_id = "";
    public $temporary_cart = [];

    protected $rules = [
        'quantity' => 'required|numeric|min:1',
        'reasonForRefund' => 'required|string',
    ];

    public function mount($transaction_code)
    {
        $transaction = Transaction::where('transaction_code', $transaction_code)->first();
        $this->customer_name = $transaction ? $transaction->customer_name : '';
        $this->transid = $transaction_code;
    }

    public function updatedSelectedItem($value)
    {
        // Find the transaction item first
        $item = TransactionItem::where('inventory_id', $value)
            ->where('code', $this->transid)
            ->first();

        // Fetch the inventory item details
        $inventoryItem = InventoryModel::find($value);

        if ($inventoryItem) {
            // Set the size and price based on the inventory item
            $this->size = $inventoryItem->size;
            $this->price = $inventoryItem->selling_price;

            if ($item) {
                // If the transaction item exists, set the quantity
                $this->quantity = $item->qty;
                $this->item_id = $value;
            } else {
                // Reset quantity if item is not found
                $this->quantity = 0;
            }
        } else {
            // If no inventory item is found, reset all values
            $this->size = null;
            $this->price = null;
            $this->quantity = 0;
        }
    }


    public function store()
    {
        $this->validate();

        // Fetch the selected inventory item to check consignment_id
        $inventoryItem = InventoryModel::find($this->selectedItem);

        // Check if the consignment_id is present
        if ($inventoryItem && $inventoryItem->consignment_id) {
            $this->dispatch('toast', type: 'info', message: 'Consignment item cannot be refunded.');
            return;
        }

        $quantity = TransactionItem::where('inventory_id', $this->item_id)
            ->where('code', $this->transid)
            ->pluck('qty')
            ->first();

        $item_name = InventoryModel::where('id', $this->selectedItem)
            ->pluck('name')
            ->first();

        if (is_null($quantity)) {
            $this->dispatch('toast', type: 'error', message: 'Item not found');
            return;
        }

        if ($this->quantity > $quantity) {
            $this->dispatch('toast', type: 'error', message: 'Invalid quantity: exceeds available stock');
            return;
        }

        foreach ($this->temporary_cart as $cartItem) {
            if ($cartItem['item'] === $item_name && $cartItem['size'] === $this->size) {
                $this->dispatch('toast', type: 'info', message: 'Item already added');
                return;
            }
        }

        // Add the item to the temporary cart
        $this->temporary_cart[] = [
            'customer_name' => $this->customer_name,
            'transaction_code' => $this->transid,
            'item_id' => $this->selectedItem,
            'item' => $item_name,
            'size' => $this->size,
            'quantity' => $this->quantity,
            'price' => $this->price
        ];
    }


    public function refund()
    {
        foreach ($this->temporary_cart as $item) {
            // Create the refund record
            Refund::create([
                'transaction_code' => $item['transaction_code'],
                'inventory_id' => $item['item_id'],
                'size' => $item['size'],
                'quantity' => $item['quantity'],
                'reason_for_refund' => $this->reasonForRefund,
                'customer_name' => $item['customer_name'],
                'status' => 'Refunded',
            ]);

            // Fetch the transaction item for updating its quantity
            $transactionItem = TransactionItem::where('inventory_id', $item['item_id'])
                ->where('code', $item['transaction_code'])
                ->first();

            if ($transactionItem) {
                // Reduce the transaction item's quantity by the refunded amount
                $transactionItem->qty -= $item['quantity'];
                if ($transactionItem->qty <= 0) {
                    $transactionItem->delete(); // Delete if the quantity is zero
                } else {
                    $transactionItem->save();
                }
            }

            $transaction = Transaction::where('transaction_code', $item['transaction_code'])->first();

            if ($transaction) {
                $transaction->quantity_sold -= $item['quantity'];
                $transaction->total_amount -= $item['price'];
                if ($transaction->quantity_sold <= 0) {
                    $transaction->delete();
                } else {
                    $transaction->save();
                }
            }
        }

        $this->clearItems();
        $this->dispatch('toast', type: 'success', message: 'Refund processed successfully');
    }



    public function clearItems()
    {
        $this->temporary_cart = [];
    }

    public function render()
    {
        return view('livewire.admin.create-refund', [
            'rows' => TransactionItem::leftJoin('inventories', 'transaction_items.inventory_id', '=', 'inventories.id')
                ->select('inventories.id', 'inventories.name', 'inventories.picture', 'inventories.selling_price', 'inventories.qty', 'inventories.size', 'transaction_items.*')
                ->where('transaction_items.code', $this->transid)
                ->get(),
            'cart' => is_array($this->temporary_cart) ? $this->temporary_cart : []
        ]);
    }
}
