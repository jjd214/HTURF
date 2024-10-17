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

    #[Url()]
    public $per_page;
    #[Url(history: true)]
    public $search = '';
    #[Url(history: true)]
    public $filter = '';
    #[Url(history: true)]
    public $genderFilter = '';
    public $cart = [];
    public $quantities = [];
    public $amountPay = 0;
    public $totalAmount = 0;
    public $change = 0;
    public $customer_name;

    protected $rules = ['customer_name' => 'required'];

    public function checkout()
    {
        $this->validate();
        if ($this->amountPay < $this->totalAmount || $this->totalAmount == 0) {
            $this->dispatch('toast', type: 'error', message: 'Payment amount must be greater than or equal to the total amount.');
            return;
        }

        session()->put('order_summary', [
            'customer_name' => $this->customer_name,
            'total_amount' => $this->totalAmount,
            'amount_pay' => $this->amountPay,
            'change' => $this->change,
            'cart' => $this->cart,
            'invoice_number' => $this->generateInvoiceNumber(),
            'transaction_code' => $this->generateTransactionCode(),
            'commission' => $this->calculateCommission()
        ]);

        return redirect()->route('admin.sales.order-summary');
    }

    public function store()
    {

        if (!session()->has('order_summary')) {
            $this->dispatch('toast', type: 'error', message: 'No order summary found.');
            return;
        }

        // Retrieve order summary from session
        $orderSummary = session('order_summary');

        dd($orderSummary);
    }


    public function calculateCommission()
    {
        $totalCommission = 0;

        foreach ($this->cart as $productId => $cartItem) {
            $product = InventoryModel::find($productId);

            if ($product->consignment_id) {
                $consignment = Consignment::find($product->consignment_id);
                $commissionPercentage = $consignment->commission_percentage;

                $productCommission = ($cartItem['total'] * $commissionPercentage) / 100;
                $totalCommission += $productCommission;
            }
        }

        return $totalCommission;
    }


    public function generateInvoiceNumber()
    {
        $prefix = 'INV-';
        $date = now()->format('Ymd');
        $randomNumber = random_int(1000, 9999);
        return $prefix . $date . '-' . $randomNumber;
    }

    public function generateTransactionCode()
    {
        $prefix = 'TRANSID-';
        $timestamp = now()->format('YmdHis');
        $randomNumber = random_int(1000, 9999);
        return $prefix . $timestamp . '-' . $randomNumber;
    }

    public function addToCart($productId)
    {
        $product = InventoryModel::find($productId);

        if (!$product) {
            $this->dispatch('toast', type: 'error', message: 'Product not found.');
            return;
        }

        $selectedQty = $this->quantities[$productId] ?? 1;

        if ($selectedQty > $product->qty) {
            $this->dispatch('toast', type: 'error', message: 'Selected quantity exceeds available quantity.');
            return;
        }

        // Deduct available quantity
        $product->qty -= $selectedQty;
        $product->save();

        // Safeguard: Ensure SKU exists before adding to cart
        $sku = $product->sku ?? 'N/A'; // Provide a fallback in case SKU is null

        // Add to cart and calculate total
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['qty'] += $selectedQty;
            $this->cart[$productId]['total'] = $this->cart[$productId]['qty'] * $this->cart[$productId]['price'];
        } else {
            $this->cart[$productId] = [
                'sku' => $sku, // Safeguard for SKU
                'name' => $product->name,
                'price' => $product->selling_price,
                'qty' => $selectedQty,
                'total' => $product->selling_price * $selectedQty,
                'picture' => $product->picture // Add product picture to cart
            ];
        }

        // Save the updated cart to the session
        session()->put('cart', $this->cart);

        $this->updateTotals();
    }

    public function removeFromCart($productId)
    {
        $product = InventoryModel::find($productId);
        $cartItem = $this->cart[$productId];

        // Restore available quantity
        $product->qty += $cartItem['qty'];
        $product->save();

        // Remove from cart
        unset($this->cart[$productId]);

        // Update the session
        session()->put('cart', $this->cart);

        $this->updateTotals();
    }

    public function clearCart()
    {
        // Restore quantities of all products in the cart
        foreach ($this->cart as $productId => $cartItem) {
            $product = InventoryModel::find($productId);
            if ($product) {
                // Restore the available quantity
                $product->qty += $cartItem['qty'];
                $product->save();
            }
        }

        // Clear the cart
        $this->cart = [];
        session()->forget('cart');
        $this->updateTotals();
    }

    public function updateTotals()
    {
        $this->totalAmount = array_sum(array_column($this->cart, 'total'));

        if ($this->amountPay > 0) {
            $this->change = $this->amountPay - $this->totalAmount;
        } else {
            $this->change = 0;
        }
    }

    public function mount()
    {
        // Retrieve cart from session if available
        $this->cart = session()->get('cart', []);
        $this->updateTotals();
    }

    public function render()
    {
        $products = InventoryModel::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('sku', $this->search);
        })->when($this->filter !== '', function ($query) {
            if ($this->filter == '0') {
                $query->where('consignment_id', '!=', null);
            } elseif ($this->filter == '1') {
                $query->where('consignment_id', '=', null);
            }
        })->when($this->genderFilter !== '', function ($query) {
            $query->where('sex', $this->genderFilter);
        })->where('visibility', 'public')
            ->paginate($this->per_page);

        return view('livewire.admin.sales-post', [
            'rows' => $products
        ]);
    }
}
