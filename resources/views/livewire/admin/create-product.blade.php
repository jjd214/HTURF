<div>
    <form wire:submit.prevent="store" id="add-product-form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-20">
                <div class="card-box height-100-p pd-20" style="position: relative; height: auto;">
                    <div class="form-group">
                        <label for=""><b>Product name:</b></label>
                        <input type="text" class="form-control" wire:model="name" placeholder="Enter product name">
                        @error('name')
                            <span class="text-danger"> <small>{{ $message }}</small> </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Brand name:</b></label>
                        <input type="text" class="form-control" wire:model="brand" placeholder="Enter brand name">
                        @error('brand')
                            <span class="text-danger"> <small>{{ $message }}</small> </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Sku:</b></label>
                        <input type="text" class="form-control" wire:model="sku" placeholder="Enter style code">
                        @error('sku')
                            <span class="text-danger"> <small>{{ $message }}</small> </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Colorway:</b></label>
                        <input type="text" class="form-control" wire:model="color" placeholder="Enter color">
                        @error('color')
                            <span class="text-danger"> <small>{{ $message }}</small> </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Size</b></label>
                        <input type="text" class="form-control" wire:model="size" placeholder="Enter size">
                        @error('size')
                            <span class="text-danger"> <small> {{ $message }}</small> </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Product description:</b></label>
                        <textarea wire:model="description" class="form-control" cols="30" rows="10"
                            placeholder="Enter product description (Optional)"></textarea>
                        @error('description')
                            <span class="text-danger"> <small>{{ $message }} </small> </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Picture:</b></label>
                        <input type="file" class="form-control" multiple wire:model="pictures"
                            accept="image/png, image/jpeg" id="picture-input">
                        <span class="pd-5"><small><b>Note:</b> You can select multiple images</small></span>
                        @error('pictures')
                            <span class="text-danger"> <small>{{ $message }}</small> </span>
                        @enderror
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
                </div>
            </div>
            <div class="col-md-6 mb-20">
                {{-- <div class="card-box min-height-100px pd-20" style="position: relative;">
                    <div class="row pd-10">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=""><b>Visibility of product:</b></label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadioPublic" value="public" wire:model="visibility"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioPublic">Public</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadioPrivate" value="private"
                                        wire:model="visibility" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioPrivate">Private</label>
                                </div>
                                @error('visibility')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card-box min-height-100px pd-20">
                    <div class="row pd-10">
                        <div class="col-md-12">
                            <label for=""><b>Sex</b></label>
                            <select wire:model.live="sex" class="form-control">
                                <option value="" selected>{{ __(' -- Options --') }}</option>
                                <option value="unisex">Unisex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('sex')
                                <span class="text-danger"> <small>{{ $message }}</small></span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-box min-height-200px pd-20" style="margin-top: 20px; height: auto;">
                    <div class="row pd-10">
                        <!-- Purchase Price -->
                        <div class="col-12 col-sm-6 mb-10">
                            <div class="form-group">
                                <label for=""><b>Purchase price:</b></label>
                                <input type="number" wire:model="purchase_price" class="form-control"
                                    placeholder="Enter purchase price" min="0">
                                @error('purchase_price')
                                    <span class="text-danger"> <small>{{ $message }}</small> </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Selling Price -->
                        <div class="col-12 col-sm-6 mb-10">
                            <div class="form-group">
                                <label for=""><b>Selling price:</b></label>
                                <input type="number" wire:model="selling_price" class="form-control"
                                    placeholder="Enter selling price" min="0">
                                @error('selling_price')
                                    <span class="text-danger"> <small>{{ $message }}</small> </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row pd-10">
                        <!-- Quantity in Stock -->
                        <div class="col-12 mb-10">
                            <div class="form-group">
                                <label for=""><b>Quantity in stock:</b></label>
                                <input type="number" wire:model="qty" class="form-control"
                                    placeholder="Enter quantity in stock">
                                @error('qty')
                                    <span class="text-danger"> <small>{{ $message }}</small> </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($pictures)
            <div class="row">
                <div class="col-12">
                    <div class="card-box pd-20 mb-20">
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($pictures as $index => $picture)
                                <img src="{{ $picture->temporaryUrl() }}" class="img-thumbnail"
                                    style="width: 150px; height: 150px; object-fit: cover;"
                                    wire:click.prevent="removePicture({{ $index }})">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12 d-flex justify-content-start gap-2 mb-20">
                <!-- Button for larger screens -->
                <button class="btn btn-success d-none d-md-inline-block btn-md">Add Product</button>

                <!-- Button for smaller screens -->
                <button class="btn btn-success d-md-none w-100">Add Product</button>
            </div>

        </div>
    </form>
</div>
