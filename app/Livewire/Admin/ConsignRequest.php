<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ConsignmentRequest;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Crypt;

class ConsignRequest extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url()]
    public $per_page = 5;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $status = '';

    public function requestDetails($id)
    {
        $encodedId = Crypt::encryptString($id);
        return redirect()->route('admin.consignment.details', ['id' => $encodedId]);
    }

    public function render()
    {
        $query = ConsignmentRequest::leftJoin('users', 'users.id', '=', 'consignment_requests.consignor_id')
            ->select('users.*', 'consignment_requests.*', 'users.name AS consignorName')
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('consignment_requests.name', 'like', '%' . $this->search . '%')
                        ->orWhere('consignment_requests.sku', 'like', '%' . $this->search . '%')
                        ->orWhere('consignment_requests.brand', 'like', '%' . $this->search . '%');
                }
            })
            ->when($this->status != '', function ($query) {
                $query->where('status', $this->status);
            });

        $query->orderBy('consignment_requests.id', 'desc');

        return view('livewire.admin.consign-request', [
            'rows' => $query->paginate($this->per_page)
        ]);
    }
}
