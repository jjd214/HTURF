<?php

namespace App\Livewire\Admin;

use App\Models\Expense;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Inventory as InventoryModel;
use Illuminate\Support\Facades\Log;

class CreateProduct extends Component
{
    use WithFileUploads;

    public $name, $brand, $sku, $color, $size, $description, $pictures = [], $visibility = 'public', $sex, $purchase_price, $selling_price, $qty;

    protected $rules = [
        'name' => 'required',
        'brand' => 'required',
        'sku' => 'required',
        'color' => 'required',
        'sex' => 'required',
        'size' => 'required|numeric',
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

        $product = InventoryModel::create([
            'name' => $validatedData['name'],
            'brand' => $validatedData['brand'],
            'sku' => $validatedData['sku'],
            'size' => $validatedData['size'],
            'color' => $validatedData['color'],
            'sex' => $validatedData['sex'],
            'qty' => $validatedData['qty'],
            'description' => $validatedData['description'],
            'purchase_price' => $validatedData['purchase_price'],
            'selling_price' => $validatedData['selling_price'],
            'picture' => $validatedData['pictures'] ?? '[]',
            'visibility' => $validatedData['visibility']
        ]);

        Expense::create([
            'inventory_id' => $product->id,
            'purchase_price' => $product->purchase_price,
            'qty' => $product->qty
        ]);

        $this->reset();
        Log::info("Product added successfully", [
            'timestamp' => now()->format('F j, Y g:i A'),
            'product' => [
                'name' => $product->name,
                'brand' => $product->brand,
                'sku' => $product->sku,
                'size' => $product->size,
                'color' => $product->color,
                'sex' => $product->sex,
                'quantity' => $product->qty,
                'purchase_price' => $product->purchase_price,
                'selling_price' => $product->selling_price,
                'visibility' => $product->visibility,
                'images' => $product->picture
            ]
        ]);
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
