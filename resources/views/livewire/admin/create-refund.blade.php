<div>
    <div class="row">
        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 mb-30">
            <div class="pd-20 card-box height-100-p">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><b>Customer name: </b></label>
                            <input type="text" class="form-control" wire:model="customer_name" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><b>Item: </b></label>
                            <select class="custom-select form-control" wire:model.defer="selectedItem" id="itemSelect">
                                <option value="" selected>Select an item</option>
                                @foreach ($rows as $item)
                                    <option value="{{ $item->inventory_id }}" {{ $item->inventory_id == $selectedItem ? 'selected' : '' }}>
                                        {{ $item->name }} ({{ $item->size }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><b>Size: </b></label>
                            <input type="number" class="form-control" wire:model.defer="size" readonly>
                            @error('size')
                                <span class="text-danger"><small>{{ $message }}</small></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><b>Price: </b></label>
                            <input type="number" class="form-control" wire:model.defer="price" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><b>Quantity: </b></label>
                            <input type="number" class="form-control" wire:model.defer="quantity">
                            @error('quantity')
                                <span class="text-danger"><small>{{ $message }}</small></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><b>Reason for refund: </b></label>
                            <textarea name="reason" class="form-control" wire:model="reasonForRefund" placeholder="Required"></textarea>
                            @error('reasonForRefund')
                                <span class="text-danger"><small>{{ $message }}</small></span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" wire:click.prevent="store">Confirm</button>
            </div>
        </div>

        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden pd-20">
                <div class="row">
                    <div class="col-md-12">
                        @forelse ($cart as $item)
                        <label for=""><b>Item: </b></label>
                        <p>{{ $item['item'] }}</p>
                        <label for=""><b>Size: </b></label>
                        <p>{{ $item['size'] }}</p>
                        <label for=""><b>Quantity: </b></label>
                        <p>{{ $item['quantity'] }}</p>
                        <label for=""><b>Price: </b></label>
                        <p>{{ number_format($item['price']) }}</p>
                        <hr>
                        @empty
                        <div class="text-center" style="margin-top: 250px;">
                            <i class="fa fa-times-circle" style="font-size: 70px; color: gray;"></i>
                            <p class="mt-2" style="color: gray;">No items selected.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if (count($cart) > 0)
                            <button class="btn btn-danger" wire:click.prevent="refund">Refund</button>
                            <button class="btn btn-secondary" wire:click.prevent="clearItems">Clear</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#itemSelect').on('change', function(e) {
                @this.set('selectedItem', $(this).val());
            });
        });
    </script>
</div>
