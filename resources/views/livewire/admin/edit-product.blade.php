<div>
    @if ( $editForm )
    <form wire:submit.prevent="store" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-20">
                <div class="card-box height-100-p pd-20" style="position: relative; height: auto;">
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
                        <input type="file" class="form-control" multiple wire:model="temporary_pictures" accept="image/png, image/jpeg" id="picture-input">
                        <span class="pd-5"><small><b>Note:</b> You can select multiple images</small></span>
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
                        <div class="col-md-12 mb-10">
                            <div class="form-group">
                                <label for=""><b>Quantity in stock:</b></label>
                                <input type="number" wire:model.defer="qty" class="form-control" placeholder="Enter quantity in stock">
                                @error('qty') <span class="text-danger"> {{ $message }} </span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($pictures && !$temporary_pictures)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box pd-20 mb-20">
                            <div class="d-flex flex-wrap gap-4">
                                @foreach ($pictures as $picture)
                                    <img src="{{ Storage::url('images/products/' . trim($picture, '[]"')) }}" class="img-thumbnail" style="width: 200px; height: 200px; object-fit: cover; margin-right: 10px;" wire:click.prevent="removePicture({{ json_encode(trim($picture, '[]"')) }})"
                                    >
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($temporary_pictures)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box pd-20 mb-20">
                            <div class="d-flex flex-wrap gap-4">
                                @if($pictures)
                                    @foreach ($pictures as $picture)
                                        <img src="{{ Storage::url('images/products/' . trim($picture, '[]"')) }}" class="img-thumbnail" style="width: 200px; height: 200px; object-fit: cover; margin-right: 10px;" wire:click.prevent="removePicture({{ json_encode(trim($picture, '[]"')) }})"
                                        >
                                    @endforeach
                                @endif
                                @foreach ($temporary_pictures as $index => $tempPicture)
                                    <img src="{{ $tempPicture->temporaryUrl() }}" class="img-thumbnail"
                                        style="width: 200px; height: 200px; object-fit: cover; margin-right: 10px;"
                                        wire:click.prevent="removeTemporaryPicture({{ $index }})">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box pd-20 mb-20">
                            <div class="d-flex flex-wrap gap-4">
                                <img src="{{ asset('storage/images/default-img.png') }}" class="img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="d-flex" style="margin-bottom: 20px;">
                <button class="btn btn-success mr-2">Save changes</button>
                <button class="btn btn-info" wire:click.prevent="hideForm">Cancel</button>
            </div>
    </form>
    @endif
</div>
