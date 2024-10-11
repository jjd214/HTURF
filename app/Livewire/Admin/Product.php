<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\Inventory as InventoryModel;

class Product extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteProductHandler'];

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
        $file = $data->picture;
        $path = 'public/images/products/';

        if ($file !== null && Storage::exists($path . $file)) {
            Storage::delete($path . $file);
        }

        $data->delete();
    }

    public function render()
    {
        return view('livewire.admin.product', [
            'rows' => InventoryModel::search($this->search)
                ->when($this->visibility != '', function ($query) {
                    $query->where('visibility', $this->visibility);
                })
                ->where('consignment_id', null)
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->per_page)
        ]);
    }
}
