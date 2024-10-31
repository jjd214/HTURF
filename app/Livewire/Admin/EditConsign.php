<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Inventory as InventoryModel;
use App\Models\User;
use App\Models\Consignment;

class EditConsign extends Component
{
    use WithFileUploads;

    public $consignment_id, $name, $brand, $sku, $color, $size, $description, $temporary_picture, $picture, $visibility, $sex, $purchase_price, $selling_price, $commission_percentage, $qty, $consignor_account, $consignor_name, $start_date, $expiry_date;

    protected $rules = [
        'name' => 'required',
        'brand' => 'required',
        'sku' => 'required',
        'color' => 'required',
        'size' => 'required|min:0',
        'qty' => 'required|integer|min:0',
        'description' => 'nullable',
        'picture' => 'nullable',
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
        $this->picture = $product->picture;
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
        $this->temporary_picture = null;
    }

    public function store()
    {
        $this->validate();

        $product = InventoryModel::where('consignment_id', $this->consignment_id)->first();
        $consignment = Consignment::find($this->consignment_id);

        if ($this->temporary_picture) {
            $path = 'public/images/consignments/';
            $old_picture = $product->picture;
            $filename = 'IMG_' . uniqid() . '.' . $this->temporary_picture->getClientOriginalExtension();

            if ($old_picture !== null && Storage::exists($path . $old_picture)) {
                Storage::delete($path . $old_picture);
            }
            $this->temporary_picture->storeAs('images/consignments/', $filename, 'public');
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
        $consignment->commission_percentage = $this->commission_percentage;
        $consignment->start_date = $this->start_date;
        $consignment->expiry_date = $this->expiry_date;

        $this->temporary_picture = null;

        $product->save();
        $consignment->save();
        $this->hideForm();
        $this->dispatch('toast', type: 'success', message: 'Consignment updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.edit-consign', [
            'rows' => User::orderBy('email', 'ASC')->get()
        ]);
    }
}
