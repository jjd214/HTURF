<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Transaction as TransactionModel;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Transaction extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url(history: true)]
    public $search;

    public $status;

    #[Url()]
    public $per_page = 5;

    public function render()
    {
        // Query transactions with eager-loaded items
        $query = TransactionModel::with('items')
            ->when($this->search, function ($query) {
                $query->where('transaction_code', 'like', '%' . $this->search . '%')
                    ->orWhere('customer_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->status != '', function ($query) {
                $query->where('status', $this->status);
            })
            ->paginate($this->per_page);

        return view('livewire.admin.transaction', ['rows' => $query]);
    }
}
