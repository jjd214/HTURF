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

        if ($orderSummary === null) {
            // $this->dispatch('toast', type: 'error', message: 'Something went wrong try again.');
            // return;

            session()->flash('toast', [
                'type' => 'fail',
                'message' => 'Something went wrong, please try again.'
            ]);
            return redirect()->route('admin.sales.add-sales');
        }
        dd($orderSummary);
    }

    public function render()
    {
        return view('livewire.admin.order-summary');
    }
}
