<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Inventory as InventoryModel;
use Illuminate\Support\Facades\Log;

class EditProduct extends Component
{
    use WithFileUploads;

    public bool $editForm = false;

    public $product_id, $name, $brand, $sku, $color, $size, $description, $temporary_pictures = [], $pictures = [], $visibility, $sex, $purchase_price, $selling_price, $qty;

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
        'pictures.*' => 'nullable',
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
        $this->pictures = explode(',', $product->picture);
        $this->visibility = $product->visibility;
        $this->sex = $product->sex;
        $this->purchase_price = $product->purchase_price;
        $this->selling_price = $product->selling_price;
        $this->qty = $product->qty;
    }

    public function hideForm()
    {
        $this->editForm = false;
        $this->temporary_pictures = null;
    }

    public function store()
    {
        $this->validate();
        $product = InventoryModel::find($this->product_id);
        $imagePaths = json_decode($product->picture, true);

        if ($this->temporary_pictures) {
            foreach ($this->temporary_pictures as $temporary_picture) {
                $filename = 'IMG_' . uniqid() . '.' . $temporary_picture->getClientOriginalExtension();
                $temporary_picture->storeAs('images/products/', $filename, 'public');
                array_push($imagePaths, $filename);
            }
            $product->picture = json_encode($imagePaths);
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

        $this->temporary_pictures = null;

        $product->save();
        Log::info('Product updated successfully', [
            'timestamp' => now()->format('F j, Y g:i A'),
            'product_id' => $product->id,
            'updated_details' => [
                'name' => $product->name,
                'brand' => $product->brand,
                'sku' => $product->sku,
                'color' => $product->color,
                'size' => $product->size,
                'description' => $product->description,
                'visibility' => $product->visibility,
                'sex' => $product->sex,
                'purchase_price' => $product->purchase_price,
                'selling_price' => $product->selling_price,
                'quantity' => $product->qty,
                'pictures' => $product->picture
            ]
        ]);
        $this->hideForm();
        $this->dispatch('toast', type: 'success', message: 'Product updated successfully.');
    }

    public function removeTemporaryPicture($pictureIndex)
    {
        if (isset($this->temporary_pictures[$pictureIndex])) {
            unset($this->temporary_pictures[$pictureIndex]);
            // Re-index array to avoid gaps
            $this->temporary_pictures = array_values($this->temporary_pictures);
        }
    }

    public function removePicture($picture)
    {
        // Retrieve the product
        $product = InventoryModel::find($this->product_id);

        // Decode the JSON array from the `picture` column
        $imagePaths = json_decode($product->picture, true);

        // Ensure $imagePaths is a valid array
        if (!is_array($imagePaths)) {
            $imagePaths = [];
        }

        // Find the index of the picture to be removed and unset it
        if (($key = array_search($picture, $imagePaths)) !== false) {
            unset($imagePaths[$key]);

            // Delete the image file from storage if it exists
            $filePath = 'images/products/' . $picture;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // Update the product's `picture` column with the modified array
        $product->picture = json_encode(array_values($imagePaths)); // Re-index the array
        $product->save();

        // Update the local `pictures` array to reflect the changes
        $this->pictures = $imagePaths;
    }


    // public function removePicture($picture)
    // {
    //     // Retrieve the product
    //     $product = InventoryModel::find($this->product_id);

    //     // Decode the JSON array from the `picture` column
    //     $imagePaths = json_decode($product->picture, true);

    //     // Find the index of the picture to be removed and unset it
    //     if (($key = array_search($picture, $imagePaths)) !== false) {
    //         unset($imagePaths[$key]);

    //         // Delete the image file from storage if it exists
    //         $filePath = 'images/products/' . $picture;
    //         if (Storage::disk('public')->exists($filePath)) {
    //             Storage::disk('public')->delete($filePath);
    //         }
    //     }

    //     // Update the product's `picture` column with the modified array
    //     $product->picture = json_encode(array_values($imagePaths)); // Re-index the array
    //     $product->save();

    //     // Update the local `pictures` array to reflect the changes
    //     $this->pictures = $imagePaths;
    // }

    public function render()
    {
        return view('livewire.admin.edit-product');
    }
}
