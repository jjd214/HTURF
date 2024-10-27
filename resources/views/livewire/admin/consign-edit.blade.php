<div>
    @if ( $editForm )
    <form wire:submit.prevent="store" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-20">
                <div class="card-box height-100-p pd-20" style="position: relative; height: 1050px;">
                    <div class="form-group">
                        <label for=""><b>Product name:</b></label>
                        <input type="text" class="form-control" wire:model.defer="name" placeholder="Enter product name">
                        @error('name') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Brand name:</b></label>
                        <input type="text" class="form-control" wire:model.defer="brand" placeholder="Enter brand name">
                        @error('brand') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Style code:</b></label>
                        <input type="text" class="form-control" wire:model.defer="sku" placeholder="Enter style code">
                        @error('sku') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Color:</b></label>
                        <input type="text" class="form-control" wire:model.defer="color" placeholder="Enter color">
                        @error('color') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Size</b></label>
                        <input type="number" class="form-control" wire:model.defer="size" placeholder="Enter size">
                        @error('size') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Product description:</b></label>
                        <textarea wire:model.defer="description" class="form-control" cols="30" rows="10" placeholder="Enter product description (Optional)"></textarea>
                        @error('description') <span class="text-danger"> {{ $message }} </span> @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Picture:</b></label>
                        <input type="file" class="form-control" wire:model="temporary_picture" accept="image/png, image/jpeg" id="picture-input">
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
                    <div class="mb-3" style="max-width: 250px; height: 200px;">
                        @if ($temporary_picture)
                        <img src="{{ $temporary_picture->temporaryUrl() }}" class="img-thumbnail" style="height: 200px;">
                        @elseif ($picture)
                        <img src="{{ Storage::url('images/consignments/' . $picture) }}" class="img-thumbnail" id="image-preview" style="height: 200px;">
                        @else
                        <img src="{{ asset('storage/images/default-img.png') }}" class="img-thumbnail" alt="Default Image" style="height: 200px;">
                        @endif
                    </div>
                </div>

                <div class="d-flex" style="margin-top: 20px;">
                    <button class="btn btn-success mr-2">Add product</button>
                    <button class="btn btn-info" wire:click.prevent="hideForm">Cancel</button>
                </div>

            </div>
            <div class="col-md-6 mb-20">
                <div class="card-box min-height-100px pd-20" style="position: relative;">
                    <div class="row pd-10">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=""><b>Visibility of product:</b></label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadioPublic" value="public" wire:model.defer="visibility" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioPublic">Public</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadioPrivate" value="private" wire:model.defer="visibility" class="custom-control-input">
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
                            <select wire:model.defer="sex" class="form-control">
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
                                <input type="number" wire:model.defer="purchase_price" class="form-control" placeholder="Enter purchase price" min="0">
                                @error('purchase_price') <span class="text-danger"> {{ $message }} </span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-10">
                            <div class="form-group">
                                <label for=""><b>Selling price:</b></label>
                                <input type="number" wire:model.defer="selling_price"  class="form-control" placeholder="Enter selling price" min="0">
                                @error('selling_price') <span class="text-danger"> {{ $message }} </span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row pd-10">
                        <div class="col-md-6 mb-10">
                            <div class="form-group">
                                <label for=""><b>Consign percentage:</b></label>
                                <input type="number" wire:model.defer="commission_percentage" class="form-control" placeholder="Enter consign commission">
                                @error('commission_percentage') <span class="text-danger"> {{ $message }} </span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-10">
                            <div class="form-group">
                                <label for=""><b>Quantity:</b></label>
                                <input type="number" wire:model.defer="qty" class="form-control" placeholder="Enter quantity in stock">
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
                                <input type="text" wire:model.defer="consignor_account" class="form-control" placeholder="Consignor name" readonly>
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
                                <input type="date" wire:model.defer="start_date" class="form-control" placeholder="Consignment start date">
                                @error('start_date') <span class="text-danger"><small>{{ $message }}</small></span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="form-group">
                                <label for=""><b>Expiry date: </b></label>
                                <input type="date" wire:model.defer="expiry_date" class="form-control" placeholder="Consignment expiry date">
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
    @endif
</div>
