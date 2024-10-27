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
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><b>Quantity: </b></label>
                            <input type="number" class="form-control" wire:model.defer="quantity">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><b>Reason for refund: </b></label>
                            <textarea name="reason" class="form-control" wire:model="reasonForRefund" placeholder="Required"></textarea>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" wire:click.prevent="store">Confirm</button>
            </div>
        </div>

        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden pd-20">
                <!-- Additional content if needed -->
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
