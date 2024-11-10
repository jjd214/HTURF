<?php

namespace App\Livewire\Admin;

use App\Models\Consignment;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\Inventory as InventoryModel;
use Illuminate\Support\Str;
use App\Models\Payment;
use App\Models\TransactionItem;
use App\Models\Transaction;


class CreateSales extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $cart = [];
    public $quantities = [];
    public $updatedQuantities = [];
    public $totalAmount = 0;
    public $amountPay = 0;
    public $change = 0;
    public $customer_name;
    public $order_details;

    #[Url(history: true)]
    public $per_page = 5;
    #[Url(history: true)]
    public $search = ''; // Search input
    #[Url()]
    public $filter = ''; // Filter for consignment/store
    #[Url(history: true)]
    public $genderFilter = ''; // Filter for gender

    public function mount()
    {
        // Initialize available quantities based on inventory
        foreach (InventoryModel::all() as $item) {
            $this->updatedQuantities[$item->id] = $item->qty;
        }
    }

    public function addToCart($itemId)
    {
        // Find item in the Inventory
        $item = InventoryModel::find($itemId);

        if (!$item) {
            return;
        }

        // Retrieve selected quantity, default to 1 if not set
        $quantity = $this->quantities[$itemId] ?? 1;

        if ($quantity <= 0) {
            $this->dispatch('toast', type: 'error', message: 'Invalid input.');
            return;
        }

        // Ensure the selected quantity does not exceed the available quantity
        if ($quantity > $this->updatedQuantities[$itemId]) {
            $this->dispatch('toast', type: 'error', message: 'Selected quantity exceeds available stock.');
            return;
        }

        // Check if the item already exists in the cart
        if (isset($this->cart[$itemId])) {
            // Increment quantity in the cart
            $this->cart[$itemId]['quantity'] += $quantity;
        } else {
            // Add new item to the cart
            $this->cart[$itemId] = [
                'id' => $item->id,
                'picture' => $item->picture,
                'name' => $item->name,
                'sku' => $item->sku,
                'size' => $item->size,
                'price' => $item->selling_price,
                'quantity' => $quantity,
                'total' => $item->selling_price * $quantity
            ];
        }

        // Update the available quantity in real-time
        $this->updatedQuantities[$itemId] -= $quantity;

        // Update total amount
        $this->updateTotals();
    }

    public function updateTotals()
    {
        $this->totalAmount = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $this->cart));

        $this->change = (float) $this->amountPay - $this->totalAmount;
    }

    public function clearCart()
    {
        $this->cart = [];
        $this->totalAmount = 0;
        $this->amountPay = 0;
        $this->change = 0;
        $this->quantities = [];
    }


    public function checkout()
    {
        $this->validate([
            'customer_name' => 'required|string|max:255',
        ]);

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

        $totalItems = 0;
        $totalAmount = 0;
        $totalTax = 0;

        foreach ($this->cart as $cartItem) {
            $productId = $cartItem['id'];
            $product = InventoryModel::find($productId);

            if ($product) {
                $totalItems += $cartItem['quantity'];
                $totalAmount += $cartItem['total'];
                $productTax = 0; // Reset productTax for each product

                if ($product->consignment_id) {
                    $consignment = Consignment::find($product->consignment_id);

                    if ($consignment) {
                        $commission = $consignment->commission_percentage;
                        $productTax = ($product->selling_price * $cartItem['quantity'] * $commission) / 100;
                        $totalTax += $productTax;
                    }

                    // Generate a unique payment code
                    do {
                        $paymentCode = 'PAY-' . $consignment->consignor_id . '-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4));
                    } while (Payment::where('payment_code', $paymentCode)->exists());

                    // Insert data for payment table
                    Payment::create([
                        'inventory_id' => $productId,
                        'payment_code' => $paymentCode,
                        'quantity' => $cartItem['quantity'],
                        'tax' => $productTax,
                        'total' => ($cartItem['price'] * $cartItem['quantity']) - $productTax,
                        'status' => 'Pending',
                        'date_of_payment' => null
                    ]);
                }

                // Insert into transaction items table
                TransactionItem::create([
                    'code' => $this->order_details['transaction_code'],
                    'inventory_id' => $productId,
                    'original_price' => $cartItem['price'],
                    'qty' => $cartItem['quantity'],
                    'status' => 'Paid'
                ]);

                // Update product quantity in inventory
                $product->qty -= $cartItem['quantity'];
                $product->save();
            }
        }

        // Create main transaction record
        Transaction::create([
            'transaction_code' => $this->order_details['transaction_code'],
            'quantity_sold' => $totalItems,
            'total_amount' => $this->order_details['total_amount'],
            'amount_paid' => $this->order_details['amount_pay'],
            'amount_change' => $this->order_details['change'],
            'commission_amount' => $totalTax, // Correct total commission amount
            'status' => 'Completed',
            'customer_name' => $this->order_details['customer_name']
        ]);

        // Save cart and order details to the session and clear the cart
        session()->put('cart', $this->cart);
        session()->put('order_summary', $this->order_details);
        session()->flash('success', 'Checkout successful.');

        $this->clearCart();

        return redirect()->route('admin.sales.order-summary');
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
        $timestamp = now()->format('Ymd');
        $randomString = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
        return $prefix . $timestamp . '-' . $randomString;
    }

    public function removeFromCart($itemId)
    {
        if (isset($this->cart[$itemId])) {
            // Retrieve the quantity of the item being removed
            $quantityToRestore = $this->cart[$itemId]['quantity'];

            // Restore the quantity back to the available stock
            $this->updatedQuantities[$itemId] += $quantityToRestore;

            // Remove the item from the cart
            unset($this->cart[$itemId]);

            // Update the total amount
            $this->updateTotals();
        }
    }


    public function render()
    {
        // Build the query based on the filters
        $query = InventoryModel::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter === '1') {
            $query->where('consignment_id', '=', null);
        }

        if ($this->filter === '0') {
            $query->where('consignment_id', '!=', null);
        }

        if ($this->genderFilter) {
            $query->where('sex', $this->genderFilter);
        }

        $query->orderBy('created_at', 'desc');

        // Paginate the results
        $rows = $query->paginate($this->per_page);

        return view('livewire.admin.create-sales', [
            'rows' => $rows,
        ]);
    }
}
