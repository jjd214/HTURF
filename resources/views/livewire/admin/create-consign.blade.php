<div>
    <form wire:submit.prevent="store" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-20">
                <div class="card-box height-100-p pd-20" style="position: relative; height: 1050px;">
                    <div class="form-group">
                        <label for=""><b>Product name:</b></label>
                        <input type="text" class="form-control" wire:model="name" placeholder="Enter product name">
                        @error('name') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Brand name:</b></label>
                        <input type="text" class="form-control" wire:model="brand" placeholder="Enter brand name">
                        @error('brand') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Style code:</b></label>
                        <input type="text" class="form-control" wire:model="sku" placeholder="Enter style code">
                        @error('sku') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Color:</b></label>
                        <input type="text" class="form-control" wire:model="color" placeholder="Enter color">
                        @error('color') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Size</b></label>
                        <input type="number" class="form-control" wire:model="size" placeholder="Enter size">
                        @error('size') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Product description:</b></label>
                        <textarea wire:model="description" class="form-control" cols="30" rows="10" placeholder="Enter product description (Optional)"></textarea>
                        @error('description') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Picture:</b></label>
                        <input type="file" class="form-control" wire:model="picture" accept="image/png, image/jpeg" id="picture-input">
                        @error('picture') <span class="text-danger"> {{ $message }} </span> @enderror
                        <div wire:loading wire:target="picture" class="spinner-grow spinner-grow-sm" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <div wire:loading wire:target="picture" class="spinner-grow spinner-grow-sm" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <div wire:loading wire:target="picture" class="spinner-grow spinner-grow-sm" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                    @if ($picture)
                    <div class="mb-3" style="max-width: 250px; height: 200px;">
                        <img src="{{ $picture->temporaryUrl() }}" class="img-thumbnail" style="max-width: 100%; height: 200px;">
                    </div>
                    @endif
                </div>

                <div class="d-flex" style="margin-top: 20px;">
                    <button class="btn btn-success mr-2">Add product</button>
                    <button class="btn btn-info">Reset</button>
                </div>

            </div>
            <div class="col-md-6 mb-20">
                <div class="card-box min-height-100px pd-20" style="position: relative;">
                    <div class="row pd-10">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=""><b>Visibility of product:</b></label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadioPublic" value="public" wire:model="visibility" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioPublic">Public</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadioPrivate" value="private" wire:model="visibility" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioPrivate">Private</label>
                                </div>
                                @error('visibility')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-box min-height-100px pd-20" style="margin-top: 20px;">
                    <div class="row pd-10">
                        <div class="col-md-12">
                            <label for=""><b>Sex</b></label>
                            <select wire:model="sex" class="form-control">
                                <option value="unisex">Unisex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('sex')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-box min-height-200px pd-20" style="margin-top: 20px;">
                    <div class="row pd-10">
                        <div class="col-md-6 mb-10">
                            <div class="form-group">
                                <label for=""><b>Purchase price:</b></label>
                                <input type="number" wire:model="purchase_price" class="form-control" placeholder="Enter purchase price" min="0">
                                @error('purchase_price') <span class="text-danger"> {{ $message }} </span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-10">
                            <div class="form-group">
                                <label for=""><b>Selling price:</b></label>
                                <input type="number" wire:model="selling_price"  class="form-control" placeholder="Enter selling price" min="0">
                                @error('selling_price') <span class="text-danger"> {{ $message }} </span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row pd-10">
                        <div class="col-md-6 mb-10">
                            <div class="form-group">
                                <label for=""><b>Consign percentage:</b></label>
                                <input type="number" wire:model="commission_percentage" class="form-control" placeholder="Enter consign commission">
                                @error('commission_percentage') <span class="text-danger"> {{ $message }} </span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-10">
                            <div class="form-group">
                                <label for=""><b>Quantity:</b></label>
                                <input type="number" wire:model="qty" class="form-control" placeholder="Enter quantity in stock">
                                @error('qty') <span class="text-danger"> {{ $message }} </span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-box min-height-200px pd-20" style="position: relative; height: 390px; margin-top: 20px;">
                    <div class="row pd-10">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=""><b>Consignor account: </b></label>
                                <select wire:model="consignor_id" class="custom-select2 form-control" style="width: 100%; height: 38px">
                                    <option value="">Select account</option>
                                    <optgroup label="Email">
                                        @foreach ($rows as $item)
                                            <option value="{{ $item->id }}" >{{ $item->email }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row pd-10">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=""><b>Full name:</b></label>
                                <input type="text" wire:model.defer="consignor_name" class="form-control" placeholder="Consignor name" readonly>
                                @error('consignor_name') <span class="text-danger"><small>{{ $message }}</small></span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row pd-10">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for=""><b>Start date: </b></label>
                                <input type="date" wire:model="start_date" class="form-control" placeholder="Consignment start date">
                                @error('start_date') <span class="text-danger"><small>{{ $message }}</small></span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="form-group">
                                <label for=""><b>Pullout date: </b></label>
                                <input type="date" wire:model="expiry_date" class="form-control" placeholder="Consignment expiry date">
                                @error('expiry_date') <span class="text-danger"><small>{{ $message }} </small> </span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('.custom-select2').select2();

                // Ensure Livewire is aware of Select2 changes
                $('.custom-select2').on('change', function (e) {
                    let selectedValue = $(this).val();
                    @this.set('consignor_id', selectedValue); // Update the Livewire component
                });
            });

            // Re-initialize Select2 when Livewire is refreshed (e.g., after an update)
            Livewire.hook('message.processed', (message, component) => {
                $('.custom-select2').select2();
            });
        </script>
    </form>
</div>
