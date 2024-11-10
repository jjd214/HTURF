<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\Payment as PaymentModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Payments extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url(history: true)]
    public $search = "";

    #[Url(history: true)]
    public $status = "";

    #[Url()]
    public $per_page = 10;

    public $startDate;
    public $endDate;

    public function showPaymentForm($id)
    {
        $payment_code = DB::table('payments')
            ->where('id', $id)
            ->value('payment_code');

        return redirect()->route('admin.payment.details', ['payment_code' => $payment_code]);
    }

    public function render()
    {
        $query = PaymentModel::leftJoin('inventories', 'payments.inventory_id', '=', 'inventories.id')
            ->leftJoin('consignments', 'inventories.consignment_id', '=', 'consignments.id')
            ->leftJoin('users', 'consignments.consignor_id', '=', 'users.id')
            ->select(
                'payments.*',
                'inventories.name as inventory_name',
                'inventories.brand',
                'inventories.size',
                'inventories.color',
                'inventories.selling_price',
                'inventories.picture',
                'consignments.commission_percentage',
                'consignments.start_date',
                'consignments.expiry_date',
                'users.name as consignor_name',
                'users.username',
                'users.email'
            );

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('payments.payment_code', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.reference_no', $this->search)
                    ->orWhere('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('users.username', 'like', '%' . $this->search . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if (!empty($this->status)) {
            $query->where('payments.status', $this->status);
        }

        // Apply date range filter
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('payments.created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay(),
            ]);
        }

        $rows = $query->orderBy('payments.id', 'desc')->paginate($this->per_page);

        return view(
            'livewire.admin.payments',
            [
                'rows' => $rows
            ]
        );
    }
}
