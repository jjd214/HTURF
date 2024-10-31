<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Inventory as InventoryModel;

class EditProduct extends Component
{
    use WithFileUploads;

    public bool $editForm = false;

    public $product_id, $name, $brand, $sku, $color, $size, $description, $temporary_picture, $picture, $visibility, $sex, $purchase_price, $selling_price, $qty;

    protected $rules = [
        'name' => 'required',
        'brand' => 'required',
        'sku' => 'required',
        'color' => 'required',
        'size' => 'required',
        'qty' => 'required|integer',
        'description' => 'nullable',
        'purchase_price' => 'required|numeric',
        'selling_price' => 'required|numeric',
        'picture' => 'nullable',
        'visibility' => 'required'
    ];

    #[On('editForm')]
    public function editForm($id)
    {
        $this->editForm = true;

        $product = InventoryModel::find($id);
        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->brand = $product->brand;
        $this->sku = $product->sku;
        $this->color = $product->color;
        $this->size = $product->size;
        $this->description = $product->description;
        $this->picture = $product->picture;
        $this->visibility = $product->visibility;
        $this->sex = $product->sex;
        $this->purchase_price = $product->purchase_price;
        $this->selling_price = $product->selling_price;
        $this->qty = $product->qty;
    }

    public function hideForm()
    {
        $this->editForm = false;
        $this->temporary_picture = null;
    }

    public function store()
    {
        $this->validate();
        $product = InventoryModel::find($this->product_id);

        if ($this->temporary_picture) {
            $path = 'public/images/products/';
            $old_picture = $product->picture;
            $filename = 'IMG_' . uniqid() . '.' . $this->temporary_picture->getClientOriginalExtension();

            if ($old_picture !== null && Storage::exists($path . $old_picture)) {
                Storage::delete($path . $old_picture);
            }
            $this->temporary_picture->storeAs('images/products/', $filename, 'public');
            $product->picture = $filename;
        }

        $product->name = $this->name;
        $product->brand = $this->brand;
        $product->sku = $this->sku;
        $product->color = $this->color;
        $product->size = $this->size;
        $product->description = $this->description;
        $product->visibility = $this->visibility;
        $product->sex = $this->sex;
        $product->purchase_price = $this->purchase_price;
        $product->selling_price = $this->selling_price;
        $product->qty = $this->qty;

        $this->temporary_picture = null;

        $product->save();
        $this->hideForm();
        $this->dispatch('toast', type: 'success', message: 'Product updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.edit-product');
    }
}
