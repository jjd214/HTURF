<div>
    <form wire:submit.prevent="createConsignment">
        <div class="card-box pd-20 mb-20">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><b>Product name</b> </label>
                        <input type="text" class="form-control" placeholder="Enter product name" wire:model="name">
                        @error('name')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><b>Brand name</b> </label>
                        <input type="text" class="form-control" placeholder="Enter brand name" wire:model="brand">
                        @error('brand')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><b>Style code (SKU)</b><small class="text-info">
                                <b>Important</b></small></label>
                        <input type="text" class="form-control" placeholder="Enter sku" wire:model="sku">
                        @error('sku')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><b>Color way</b> </label>
                        <input type="text" class="form-control" placeholder="Enter colorway" wire:model="colorway">
                        @error('colorway')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><b>Size</b> </label>
                        <input type="text" class="form-control" placeholder="Enter size" wire:model="size">
                        @error('size')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><b>Sex </b> </label>
                        <select wire:model="sex" class="custom-select form-control">
                            <option value="">{{ __('-- Select option --') }}</option>
                            <option value="Unisex">Unisex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        {{-- <input type="text" class="form-control" placeholder="Enter sex" wire:model="sex"> --}}
                        @error('sex')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for=""><b>Quantity </b> </label>
                        <input type="number" class="form-control" placeholder="Enter quantity" wire:model="quantity"
                            wire:input="calculatePayoutPrice">
                        @error('quantity')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for=""><b>Condition </b> </label>
                        <select class="custom-select form-control" wire:model="condition">
                            <option value="Brand new">Brand new</option>
                            <option value="Used" @disabled(true)>Used</option>
                            <option value="Slightly used" @disabled(true)>Slightly used</option>
                        </select>
                        @error('condition')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>
                <!-- Selling Price -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for=""><b>Selling price </b></label>
                        <input type="number" id="sellingPrice" class="form-control" placeholder="Enter selling price"
                            wire:model="selling_price" wire:input="calculatePayoutPrice">

                        @error('selling_price')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>

                <!-- Consignor Commission -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for=""><b>Consignor commission % </b></label>
                        <input type="number" id="consignorCommission" class="form-control"
                            placeholder="Enter consignor commission" value="10" readonly>
                        <span class="text-info ml-2"><small><b>10% minimum</b></small></span>
                        @error('consignor_commission')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>

                <!-- Payout Price -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for=""><b>Payout price </b></label>
                        <input type="text" id="payoutPrice" class="form-control"
                            placeholder="Calculated payout price" wire:model="payout_price" readonly>
                        @error('payout_price')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for=""><b>Pullout date </b> </label>
                        <input type="date" class="form-control" placeholder="Enter pullout date"
                            wire:model="pullout_date">
                        @error('pullout_date')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for=""><b>Product description</b> </label>
                        <textarea wire:model="description" class="form-control" placeholder="Enter product description (Optional)"></textarea>
                        {{-- <input type="text" class="form-control"
                            placeholder="Enter short product description (Optional)" wire:model="description"> --}}
                        @error('description')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for=""><b>Consign image </b> </label>
                        <input type="file" class="form-control" multiple wire:model="images"
                            accept="image/png, image/jpeg">
                        @error('images')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                        <span><small class="pd-5">You can select multiple image</small></span>
                    </div>
                    <div
                        style="width: 100%; height: 100px; border: 1px solid grey; margin-top: -10px; border-radius: 7px; overflow: auto; padding: 10px;">
                        @if ($images)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-start">
                                        @foreach ($images as $index => $image)
                                            <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail"
                                                style="width: 80px; height: 80px; margin-right: 10px;"
                                                wire:click.prevent="removePicture({{ $index }})">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for=""><b>Note </b> </label>
                        <textarea class="form-control" placeholder="Note to consignor (Optional)" wire:model="note"></textarea>
                        @error('note')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-success mb-20">Submit</button>
    </form>
</div>
