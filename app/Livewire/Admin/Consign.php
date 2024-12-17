<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\Consignment;
use App\Models\Inventory as InventoryModel;
use Illuminate\Support\Facades\Log;

class Consign extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteConsignHandler'];

    #[Url()]
    public $per_page = 5;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $visibility = '';

    #[Url(history: true)]
    public $sortBy = 'created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortBy = $sortByField;

        if ($sortByField === 'expiry_date' || $sortByField === 'start_date') {
            $this->sortDir = 'ASC';
        }
        $this->sortDir = 'DESC';
    }

    public function delete($id, $name)
    {
        $this->dispatch('deleteConsign', id: $id, name: $name);
    }

    public function deleteConsignHandler($id)
    {
        $data = InventoryModel::where('consignment_id', $id)->first();
        $file = $data->picture;
        $path = 'public/images/consignments/';

        $pictures = json_decode($data->picture, true); // true ensures it's an array

        // Delete each image if it exists
        if (is_array($pictures)) {
            foreach ($pictures as $file) {
                if ($file !== null && Storage::exists($path . $file)) {
                    Storage::delete($path . $file);
                }
            }
        }

        $consignment = Consignment::findOrFail($id);
        Log::info(
            "Consignment deleted successfully",
            [
                'time_stamp' => now()->format('F j, Y g:i A'),
                'consignment_details' => [
                    'consignment_id' => $consignment->id,
                    'commission_percentage' => $consignment->commission_percentage,
                    'start_date' => $consignment->start_date,
                    'expiry_date' => $consignment->expiry_date,
                ],
                'product_details' => [
                    'consignment_id' => $id,
                    'product_id' => $data->id,
                    'product_name' => $data->name,
                    'product_sku' => $data->sku,
                    'product_brand' => $data->brand,
                    'product_color' => $data->color,
                    'product_size' => $data->size,
                    'product_description' => $data->description,
                    'product_visibility' => $data->visibility,
                    'product_sex' => $data->sex,
                    'product_purchase_price' => $data->purchase_price,
                    'product_selling_price' => $data->selling_price,
                    'product_qty' => $data->qty,
                    'product_picture' => $data->picture,
                ]
            ]
        );

        $data->delete();
    }

    public function showEditForm($id)
    {
        $this->dispatch('editForm', id: $id);
    }

    public function render()
    {
        $query = InventoryModel::leftJoin('consignments', 'inventories.consignment_id', '=', 'consignments.id')
            ->select('inventories.*', 'consignments.*')
            ->where('inventories.consignment_id', '!=', null)
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('inventories.name', 'like', '%' . $this->search . '%')
                        ->orWhere('inventories.sku', 'like', '%' . $this->search . '%')
                        ->orWhere('inventories.brand', 'like', '%' . $this->search . '%');
                }
            })
            ->when($this->visibility != '', function ($query) {
                $query->where('visibility', $this->visibility);
            });

        if ($this->sortBy === 'expiry_date') {
            $query->orderBy('consignments.expiry_date', $this->sortDir);
        } elseif ($this->sortBy === 'start_date') {
            $query->orderBy('consignments.start_date', $this->sortDir);
        } else {
            $query->orderBy('inventories.' . $this->sortBy, $this->sortDir);
        }

        return view('livewire.admin.consign', [
            'rows' => $query->paginate($this->per_page),
        ]);
    }
}
