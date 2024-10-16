<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class OrderSummary extends Component
{
    public $orderSummary;

    protected $listeners = ['removeOrderSummary'];

    public function mount()
    {
        // Check if order summary exists in the session
        if (!session()->has('order_summary')) {
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
        dd($orderSummary);
    }
    public function render()
    {
        return view('livewire.admin.order-summary');
    }
}
