<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\Inventory as InventoryModel;
use Illuminate\Support\Facades\Log;

class Product extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteProductHandler'];

    #[Url()]
    public $per_page = 5;

    #[Url(history: true)]
    public $search = '';

    #[Url('status', history: true)]
    public $visibility = '';

    #[Url(history: true)]
    public $sortBy = 'created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    public function showEditForm($id)
    {
        $this->dispatch('editForm', $id);
    }

    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function delete($id, $name)
    {
        $this->dispatch('deleteProduct', id: $id, name: $name);
    }

    public function deleteProductHandler($id)
    {
        $data = InventoryModel::find($id);

        if (!$data) {
            Log::warning("Attempted to delete a product that does not exist.", [
                'timestamp' => now()->format('F j, Y g:i A'),
                'product_id' => $id
            ]);
            return;
        }

        // Define the storage path
        $path = 'public/images/products/';

        // Decode the JSON `picture` field (assuming it's a JSON array)
        $pictures = json_decode($data->picture, true); // true ensures it's an array

        // Delete each image if it exists
        if (is_array($pictures)) {
            foreach ($pictures as $file) {
                if ($file !== null && Storage::exists($path . $file)) {
                    Storage::delete($path . $file);
                }
            }
        }

        // Log product deletion details
        Log::info('Product deleted successfully', [
            'timestamp' => now()->format('F j, Y g:i A'),
            'product_id' => $data->id,
            'deleted_details' => [
                'name' => $data->name,
                'brand' => $data->brand,
                'sku' => $data->sku,
                'color' => $data->color,
                'size' => $data->size,
                'description' => $data->description,
                'visibility' => $data->visibility,
                'sex' => $data->sex,
                'purchase_price' => $data->purchase_price,
                'selling_price' => $data->selling_price,
                'quantity' => $data->qty,
                'pictures' => $data->picture
            ]
        ]);

        // Delete the product record
        $data->delete();
    }

    public function render()
    {
        return view('livewire.admin.product', [
            'rows' => InventoryModel::search($this->search)
                ->when($this->visibility, function ($query) {
                    if ($this->visibility == 'in_stock') {
                        $query->where('qty', '>', 0); // Fetch rows where qty > 0
                    } elseif ($this->visibility == 'out_of_stock') {
                        $query->where('qty', '=', 0); // Fetch rows where qty = 0
                    }
                })
                ->where('consignment_id', null)
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->per_page)
        ]);
    }
}
