<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Inventory as InventoryModel;

class CreateProduct extends Component
{
    use WithFileUploads;

    public $name, $brand, $sku, $color, $size, $description, $pictures = [], $visibility, $sex, $purchase_price, $selling_price, $qty;

    protected $rules = [
        'name' => 'required',
        'brand' => 'required',
        'sku' => 'required',
        'color' => 'required',
        'size' => 'required|min:0',
        'description' => 'nullable',
        'purchase_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'pictures.*' => 'nullable|image',
        'visibility' => 'required',
        'qty' => 'required|integer|min:1'
    ];

    public function store()
    {
        $validatedData = $this->validate();
        $imagePaths = [];

        if ($this->pictures) {
            foreach ($this->pictures as $picture) {
                $filename = 'IMG_' . uniqid() . '.' . $picture->getClientOriginalExtension();
                $picture->storeAs('images/products/', $filename, 'public');
                array_push($imagePaths, $filename);
            }
            $validatedData['pictures'] = json_encode($imagePaths);
        }

        // dd($validatedData['pictures']);

        InventoryModel::create([
            'name' => $validatedData['name'],
            'brand' => $validatedData['brand'],
            'sku' => $validatedData['sku'],
            'size' => $validatedData['size'],
            'color' => $validatedData['color'],
            'qty' => $validatedData['qty'],
            'description' => $validatedData['description'],
            'purchase_price' => $validatedData['purchase_price'],
            'selling_price' => $validatedData['selling_price'],
            'picture' => $validatedData['pictures'],
            'visibility' => $validatedData['visibility']
        ]);
        $this->reset();

        $this->dispatch('toast', type: 'success', message: 'Product added successfully.');
    }

    public function removePicture($pictureIndex)
    {
        if (isset($this->pictures[$pictureIndex])) {
            unset($this->pictures[$pictureIndex]);
            // Re-index array to avoid gaps
            $this->pictures = array_values($this->pictures);
        }
    }


    public function render()
    {
        return view('livewire.admin.create-product');
    }
}
