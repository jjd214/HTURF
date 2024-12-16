<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Inventory as InventoryModel;
use App\Models\User;
use App\Models\Consignment;
use Illuminate\Support\Facades\Log;

class EditConsign extends Component
{
    use WithFileUploads;

    public $consignment_id, $name, $brand, $sku, $color, $size, $description, $temporary_pictures = [], $pictures = [], $visibility, $sex, $purchase_price, $selling_price, $commission_percentage, $qty, $consignor_account, $consignor_name, $start_date, $expiry_date;

    protected $rules = [
        'name' => 'required',
        'brand' => 'required',
        'sku' => 'required',
        'color' => 'required',
        'size' => 'required|min:0',
        'qty' => 'required|integer|min:0',
        'description' => 'nullable',
        'pictures.*' => 'nullable',
        'visibility' => 'required',
        'purchase_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'commission_percentage' => 'required|numeric|min:0',
        'qty' => 'required|integer|min:1',
        'consignor_name' => 'required',
        'start_date' => 'required|date',
        'expiry_date' => 'required|date|after:start_date'
    ];

    public bool $editForm = false;

    #[On('editForm')]
    public function editForm($id)
    {
        $this->editForm = true;

        $product = InventoryModel::leftJoin('consignments', 'inventories.consignment_id', '=', 'consignments.id')
            ->leftJoin('users', 'consignments.consignor_id', '=', 'users.id')
            ->select('inventories.*', 'consignments.*', 'users.name as userName', 'users.email as userEmail')
            ->where('inventories.consignment_id', '=', $id)
            ->first();

        $this->consignment_id = $product->consignment_id;
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

        $this->commission_percentage = $product->commission_percentage;
        $this->start_date = $product->start_date;
        $this->expiry_date = $product->expiry_date;

        $this->consignor_account = $product->userEmail;
        $this->consignor_name = $product->userName;
    }

    public function hideForm()
    {
        $this->editForm = false;
        $this->temporary_pictures = null;
    }

    public function store()
    {
        $this->validate();

        $product = InventoryModel::where('consignment_id', $this->consignment_id)->first();
        $consignment = Consignment::find($this->consignment_id);

        $imagePaths = json_decode($product->picture, true);

        if ($this->temporary_pictures) {
            foreach ($this->temporary_pictures as $temporary_picture) {
                $filename = 'IMG_' . uniqid() . '.' . $temporary_picture->getClientOriginalExtension();
                $temporary_picture->storeAs('images/consignments/', $filename, 'public');
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
        $consignment->commission_percentage = $this->commission_percentage;
        $consignment->start_date = $this->start_date;
        $consignment->expiry_date = $this->expiry_date;

        $this->temporary_pictures = null;

        $product->save();
        $consignment->save();

        Log::info(
            "Consignment updated successfully",
            [
                'time_stamp' => now()->format('F j, Y g:i A'),
                'consignment_details' => [
                    'consignment_id' => $consignment->id,
                    'commission_percentage' => $consignment->commission_percentage,
                    'start_date' => $consignment->start_date,
                    'expiry_date' => $consignment->expiry_date,
                ],
                'product_details' => [
                    'product_id' => $product->id,
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
                    'qty' => $product->qty,
                ]
            ]
        );

        $this->hideForm();
        $this->dispatch('toast', type: 'success', message: 'Consignment updated successfully.');
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
        // Retrieve the product based on consignment_id
        $product = InventoryModel::where('consignment_id', $this->consignment_id)->first();

        if (!$product) {
            // If no product is found, exit the function
            return;
        }

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
            $filePath = 'images/consignments/' . $picture;
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


    public function render()
    {
        return view('livewire.admin.edit-consign', [
            'rows' => User::orderBy('email', 'ASC')->get()
        ]);
    }
}
