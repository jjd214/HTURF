<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Inventory as InventoryModel;

class CreateProduct extends Component
{
    use WithFileUploads;

    public $name, $brand, $sku, $color, $size, $description, $picture, $visibility, $sex, $purchase_price, $selling_price, $qty;

    protected $rules = [
        'name' => 'required',
        'brand' => 'required',
        'sku' => 'required',
        'color' => 'required',
        'size' => 'required|min:0',
        'description' => 'nullable',
        'purchase_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'picture' => 'nullable|image',
        'visibility' => 'required',
        'qty' => 'required|integer|min:1'
    ];

    public function store()
    {
        $validatedData = $this->validate();

        if ($this->picture) {
            $filename = 'IMG_' . uniqid() . '.' . $this->picture->getClientOriginalExtension();
            $validatedData['picture'] = $filename;
            $this->picture->storeAs('images/products/', $filename, 'public');
        }

        InventoryModel::create($validatedData);
        $this->reset();

        $this->dispatch('toast', type: 'success', message: 'Product added successfully.');
    }

    public function render()
    {
        return view('livewire.admin.create-product');
    }
}
