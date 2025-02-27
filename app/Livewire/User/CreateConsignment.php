<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\ConsignmentRequest;

class CreateConsignment extends Component
{
    use WithFileUploads;

    public $consignor_id, $name, $brand, $sku, $colorway, $size, $description, $sex, $quantity, $condition = 'Brand new', $payout_price, $selling_price, $consignor_commission = 10, $pullout_date, $images = [], $note;

    public function calculatePayoutPrice()
    {
        if ($this->selling_price != null || $this->payout_price != null) {
            $selling_price = (float) $this->selling_price;
            $consignor_commission = (float) $this->consignor_commission;
            $quantity = $this->quantity;
            $this->payout_price = $selling_price - (($selling_price * $consignor_commission) / 100);

            if ($this->quantity != null) {
                $this->payout_price *= $quantity;
            }
        }
    }

    public function createConsignment()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'brand' => 'required',
            'sku' => 'required',
            'colorway' => 'required',
            'size' => 'required|numeric',
            'description' => 'nullable',
            'sex' => 'required',
            'quantity' => 'required|integer|min:1',
            'condition' => 'nullable',
            'payout_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:1',
            'consignor_commission' => 'required|numeric|min:0',
            'pullout_date' => 'required|date',
            'images.*' => 'nullable|image',
            'note' => 'nullable'
        ]);

        $this->consignor_id = auth('user')->id();

        $imagePaths = [];

        if ($this->images) {
            foreach ($this->images as $image) {
                $filename = 'IMG_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('images/requests/', $filename, 'public');
                array_push($imagePaths, $filename);
            }
            $validatedData['images'] = json_encode($imagePaths);
        }

        $consignment = new ConsignmentRequest();
        $consignment->consignor_id = $this->consignor_id;
        $consignment->name = $validatedData['name'];
        $consignment->brand = $validatedData['brand'];
        $consignment->sku = $validatedData['sku'];
        $consignment->colorway = $validatedData['colorway'];
        $consignment->size = $validatedData['size'];
        $consignment->description = $validatedData['description'];
        $consignment->sex = $validatedData['sex'];
        $consignment->quantity = $validatedData['quantity'];
        $consignment->condition = $validatedData['condition'];
        $consignment->status = "Pending";
        $consignment->payout_price = $validatedData['payout_price'];
        $consignment->selling_price = $validatedData['selling_price'];
        $consignment->consignor_commission = $validatedData['consignor_commission'];
        $consignment->pullout_date = $validatedData['pullout_date'];
        $consignment->image = $validatedData['images'] ?? '[]';
        $consignment->note = $validatedData['note'];

        $this->reset();
        $consignment->save();
        $this->dispatch('toast', type: 'success', message: 'Consignment request submitted successfully.');
    }

    public function removePicture($imageIndex)
    {
        if (isset($this->images[$imageIndex])) {
            unset($this->images[$imageIndex]);
            // Re-index array to avoid gaps
            $this->images = array_values($this->images);
        }
    }

    public function render()
    {
        return view('livewire.user.create-consignment');
    }
}
