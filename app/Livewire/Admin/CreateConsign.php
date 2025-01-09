<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Inventory as InventoryModel;
use App\Models\Consignment;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use NumberFormatter;

class CreateConsign extends Component
{
    use WithFileUploads;

    public $name, $brand, $sku, $color, $size, $description, $pictures = [], $visibility = 'public', $sex, $payout_price, $selling_price, $commission_percentage = 10, $qty, $consignor_id, $consignor_name, $start_date, $expiry_date;

    protected $rules = [
        'name' => 'required',
        'brand' => 'required',
        'sku' => 'required',
        'color' => 'required',
        'sex' => 'required',
        'size' => 'required|numeric',
        'qty' => 'required|integer|min:0',
        'description' => 'nullable',
        'pictures.*' => 'nullable|image',
        'visibility' => 'required',
        'selling_price' => 'required|numeric|min:0',
        'commission_percentage' => 'required|numeric|min:0',
        'qty' => 'required|integer|min:1',
        'consignor_name' => 'required',
        'start_date' => 'required|date',
        'expiry_date' => 'required|date|after:start_date'
    ];

    public function calculatePayoutPrice()
    {
        // Ensure numeric values
        if ($this->selling_price != null || $this->payout_price != null) {
            $selling_price = (float) $this->selling_price;
            $commission_percentage = (float) $this->commission_percentage;
            $quantity = $this->qty;
            $this->payout_price = $selling_price - (($selling_price * $commission_percentage) / 100);

            if ($this->qty != null) {
                $this->payout_price *= $quantity;
            }
        }
    }


    public function updatedConsignorId($value)
    {
        $this->showConsignorName($value);
    }

    public function showConsignorName($consignorId)
    {
        $consignor = User::find($consignorId);
        if ($consignor) {
            $this->consignor_name = $consignor->name;
        } else {
            $this->consignor_name = null;
        }
    }

    public function store()
    {
        $validatedData = $this->validate();
        $consignor =  User::find($this->consignor_id);

        $consignment = new Consignment();
        $consignment->commission_percentage = $validatedData['commission_percentage'];
        $consignment->start_date = $validatedData['start_date'];
        $consignment->expiry_date = $validatedData['expiry_date'];

        $consignment->user()->associate($consignor);
        $consignment->save();

        $imagePaths = [];

        if ($this->pictures) {
            foreach ($this->pictures as $picture) {
                $filename = 'IMG_' . uniqid() . '.' . $picture->getClientOriginalExtension();
                $picture->storeAs('images/consignments/', $filename, 'public');
                array_push($imagePaths, $filename);
            }
            $validatedData['pictures'] = json_encode($imagePaths);
        }

        $inventory = new InventoryModel();
        // $inventory->consignment_id = $consignment->id;
        $inventory->name = $validatedData['name'];
        $inventory->brand = $validatedData['brand'];
        $inventory->sku = $validatedData['sku'];
        $inventory->color = $validatedData['color'];
        $inventory->sex = $validatedData['sex'];
        $inventory->size = $validatedData['size'];
        $inventory->description = $validatedData['description'];
        $inventory->picture = $validatedData['pictures'] ?? '';
        $inventory->visibility = $validatedData['visibility'];
        $inventory->selling_price = $validatedData['selling_price'];
        $inventory->qty = $validatedData['qty'];

        $inventory->consignment()->associate($consignment);
        $inventory->save();

        Log::info(
            "Consignment added successfully",
            [
                'time_stamp' => now()->format('F j, Y g:i A'),
                'consignment_details' => [
                    'consignment_id' => $consignment->id,
                    'commission_percentage' => $consignment->commission_percentage,
                    'start_date' => $consignment->start_date,
                    'expiry_date' => $consignment->expiry_date,
                    'consignor_name' => $consignor->name,
                    'consignor_email' => $consignor->email,
                ],
                'product_details' => [
                    'inventory_id' => $inventory->id,
                    'name' => $inventory->name,
                    'brand' => $inventory->brand,
                    'sku' => $inventory->sku,
                    'color' => $inventory->color,
                    'size' => $inventory->size,
                    'quantity' => $inventory->qty,
                    'selling_price' => $inventory->selling_price,
                    'visibility' => $inventory->visibility,
                ]
            ]
        );

        $this->reset();
        $this->dispatch('toast', type: 'success', message: 'Consignment added successfully.');
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
        return view('livewire.admin.create-consign', [
            'rows' => User::orderBy('email', 'ASC')->where('verified', 1)->get()
        ]);
    }
}
