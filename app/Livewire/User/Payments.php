<?php

namespace App\Livewire\User;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\DB;

class Payments extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url(history: true)]
    public $search = '';
    #[Url(history: true)]
    public $status = '';
    #[Url()]
    public $per_page = 10;

    public function showPaymentForm($id)
    {
        $payment_code = DB::table('payments')
            ->where('id', $id)
            ->value('payment_code');

        return redirect()->route('consignor.payment.details', ['payment_code' => $payment_code]);
    }

    public function render()
    {
        $query = Payment::leftJoin('inventories', 'payments.inventory_id', '=', 'inventories.id')
            ->leftJoin('consignments', 'inventories.consignment_id', 'consignments.id')
            ->select('payments.id as paymentId', 'payments.payment_code', 'payments.quantity', 'payments.status', 'payments.date_of_payment', 'payments.reference_no', 'inventories.name', 'inventories.sku', 'inventories.id AS inventoryId')
            ->where('consignments.consignor_id', auth('user')->id());

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('payments.payment_code', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.reference_no', 'like', '%' . $this->search . '%')
                    ->orWhere('inventories.name', 'like', '%' . $this->search . '%')
                    ->orWhere('inventories.sku', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->status)) {
            $query->where('payments.status', $this->status);
        }

        $query->orderBy('paymentId', 'desc');

        $payments = $query->paginate($this->per_page);

        return view('livewire.user.payments', [
            'rows' => $payments
        ]);
    }
}
