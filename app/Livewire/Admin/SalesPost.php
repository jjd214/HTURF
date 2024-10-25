<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attrbutes\Rule;
use App\Models\Inventory as InventoryModel;
use App\Models\Consignment;
use App\Models\Transaction;
use App\Models\TransactionItem;

class SalesPost extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $rows;
    public $cart = [];
    public $order_details = [];
    public $order_summary = [];
    public $quantities = [];
    public $amountPay;
    public $totalAmount = 0;
    public $change = 0;
    public $customer_name;

    protected $rules = ['customer_name' => 'required'];

    public function mount()
    {
        // Initialize product data or fetch from the database
        $this->rows = InventoryModel::all()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'qty' => $product->qty, // Available quantity
                'selling_price' => $product->selling_price,
                'picture' => $product->picture,
                
            ];
        });
    }

    public function addToCart($productId)
    {
        // Find product
        $product = collect($this->rows)->firstWhere('id', $productId);

        // Get the selected quantity from input or default to 1
        $selectedQuantity = $this->quantities[$productId] ?? 1;

        // Check if selected quantity exceeds available quantity
        if ($selectedQuantity > $product['qty']) {
            $this->dispatch('toast', type: 'error', message: 'Selected quantity exceeds available stock.');
            return;
        }

        // Deduct selected quantity from available quantity
        $this->rows = collect($this->rows)->map(function ($item) use ($productId, $selectedQuantity) {
            if ($item['id'] == $productId) {
                $item['qty'] -= $selectedQuantity; // Deduct selected quantity from available qty
            }
            return $item;
        })->toArray();

        // Check if the product is already in the cart
        $existingCartItem = collect($this->cart)->firstWhere('id', $productId);

        if ($existingCartItem) {
            // If the product is already in the cart, update the quantity
            $this->cart = collect($this->cart)->map(function ($item) use ($productId, $selectedQuantity) {
                if ($item['id'] == $productId) {
                    $item['quantity'] += $selectedQuantity;
                }
                return $item;
            })->toArray();
        } else {
            // Add new item to cart
            $this->cart[] = [
                'id' => $productId,
                'name' => $product['name'],
                'sku' => $product['sku'],
                'quantity' => $selectedQuantity,
                'price' => $product['selling_price'],
                'total' => $product['selling_price'] * $selectedQuantity,
                'picture' => $product['picture']
            ];
        }

        // Update total amount
        $this->updateTotals();
    }

    public function removeFromCart($productId)
    {
        // Find the item in the cart
        $cartItem = collect($this->cart)->firstWhere('id', $productId);

        if ($cartItem) {
            // Restore the removed quantity to the available stock
            $this->rows = collect($this->rows)->map(function ($item) use ($productId, $cartItem) {
                if ($item['id'] == $productId) {
                    // Add back the quantity removed from the cart
                    $item['qty'] += $cartItem['quantity'];
                }
                return $item;
            })->toArray();

            // Remove the item from the cart
            $this->cart = collect($this->cart)->reject(function ($item) use ($productId) {
                return $item['id'] == $productId;
            })->toArray();

            // Update the totals
            $this->updateTotals();
        }
    }


    public function updateTotals()
    {
        // Calculate the total amount
        $this->totalAmount = collect($this->cart)->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });

        // Calculate change
        $this->change = $this->amountPay - $this->totalAmount;
    }

    public function clearCart()
    {
        // When the cart is cleared, reset the product quantities
        $this->cart = [];
        $this->totalAmount = 0;
        $this->change = 0;

        // Reset the available quantities in $rows (without fetching again)
        $this->rows = InventoryModel::all()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'qty' => $product->qty, // Reset available quantity
                'selling_price' => $product->selling_price,
                'picture' => $product->picture,
            ];
        })->toArray();
    }

    public function checkout()
    {
        $this->validate();
        if ($this->amountPay < $this->totalAmount || $this->totalAmount == 0) {
            $this->dispatch('toast', type: 'error', message: 'Payment amount must be greater than or equal to the total amount.');
            return;
        }


        $this->order_details = array(
            'customer_name' => $this->customer_name,
            'total_amount' => $this->totalAmount,
            'amount_pay' => $this->amountPay,
            'change' => $this->change,
            'transaction_code' => $this->generateTransactionCode(),
            'commission' => $this->calculateCommission()
        );

        // dd($this->order_details, $this->cart);

        $totalItems = 0;
        $totalAmount = 0;
        $totalTax = 0;

        foreach ($this->cart as $cartItem) {
            $productId = $cartItem['id'];
            $product = InventoryModel::find($productId);

            if ($product) {
                $totalItems += $cartItem['quantity'];
                $totalAmount += $cartItem['total'];

                if ($product->consignment_id) {
                    $consignment = Consignment::find($product->consignment_id);

                    if ($consignment) {
                        $commission = $consignment->commission_percentage;
                        $productTax = ($cartItem['total'] * $commission) / 100;
                        $totalTax += $productTax;
                    }
                }
                TransactionItem::create([
                    'code' => $this->order_details['transaction_code'],
                    'inventory_id' => $productId,
                    'qty' => $cartItem['quantity'],
                    'total' => $cartItem['total'],
                    'status' => 'Paid'
                ]);

                $product->qty -= $cartItem['quantity'];
                $product->save();
            }
        }

        Transaction::create([
            'transaction_code' => $this->order_details['transaction_code'],
            'quantity_sold' => $totalItems,
            'total_amount' => $totalAmount,
            'amount_paid' => $this->order_details['amount_pay'],
            'amount_change' => $this->order_details['change'],
            'commission_amount' => $totalTax,
            'status' => 'Completed',
            'customer_name' => $this->order_details['customer_name']
        ]);


        // $this->dispatch('toast', type: 'success', message: 'Checkout successfull.');

        session()->put('cart', $this->cart);
        session()->put('order_summary', $this->order_details);

        return redirect()->route('admin.sales.order-summary');

        $this->clearCart();
    }

    public function calculateCommission()
    {
        $totalCommission = 0;

        foreach ($this->cart as $cartItem) {
            $productId = $cartItem['id'];
            $product = InventoryModel::find($productId);

            if ($product && $product->consignment_id) {
                $consignment = Consignment::find($product->consignment_id);
                if ($consignment) {
                    $commissionPercentage = $consignment->commission_percentage;

                    $productCommission = ($cartItem['total'] * $commissionPercentage) / 100;
                    $totalCommission += $productCommission;
                }
            }
        }

        return $totalCommission;
    }

    public function generateTransactionCode()
    {
        $prefix = 'TRANSID-';
        $timestamp = now()->format('YmdHis');
        $randomNumber = random_int(1000, 9999);
        return $prefix . $timestamp . '-' . $randomNumber;
    }

    public function render()
    {
        return view('livewire.admin.sales-post', [
            'rows' => $this->rows,
        ]);
    }
}
