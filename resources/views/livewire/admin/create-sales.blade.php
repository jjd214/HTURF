<div>
    <div class="card-box pd-20 mb-20">
        <div class="row mb-30">
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <div class="search-container d-flex align-items-center">
                    <i class="fa fa-search search-icon"></i>
                    <input type="text" class="form-control" wire:model.live.debounce.300ms="search"
                        placeholder="Search products">
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <select class="custom-select form-control" wire:model.live="filter">
                    <option value="">All</option>
                    <option value="0">Consignment</option>
                    <option value="1">Store</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <select class="custom-select form-control" wire:model.live="genderFilter">
                    <option value="">Sex</option>
                    <option value="Unisex">Unisex</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" style="width: 100%" wire:poll.keep-alive>
                <thead>
                    <tr>
                        <th style="width: 10%">Item</th>
                        <th style="width: 10%;">Style code</th>
                        <th style="width: 15%;">Name</th>
                        <th style="width: 7%;">Size</th>
                        <th style="width: 10%;">Price</th>
                        <th style="width: 10%;">Available Qty</th>
                        <th style="width: 10%;">Selected Qty</th>
                        <th style="width: 5%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $item)
                        <tr wire:key={{ $item->id }} @if (($updatedQuantities[$item['id']] ?? $item['qty']) == 0) disabled @endif>
                            @php
                                $pictures = json_decode($item['picture'], true);
                                $firstPicture = $pictures && count($pictures) > 0 ? $pictures[0] : null;
                            @endphp
                            <td>
                                @if ($firstPicture == null)
                                    <img src="{{ asset('storage/images/default-img.png') }}" width="70"
                                        height="70" style="height: 70px !important;" alt="Default Image"
                                        class="img-thumbnail">
                                @elseif (Storage::exists('public/images/products/' . $firstPicture))
                                    <img src="{{ asset('storage/images/products/' . $firstPicture) }}" width="70"
                                        style="height: 70px !important;" alt="{{ $firstPicture }}"
                                        class="img-thumbnail">
                                @elseif (Storage::exists('public/images/consignments/' . $firstPicture))
                                    <img src="{{ asset('storage/images/consignments/' . $firstPicture) }}"
                                        width="70" style="height: 70px !important;" alt="{{ $firstPicture }}"
                                        class="img-thumbnail">
                                @endif
                            </td>
                            <td>{{ $item['sku'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['size'] }}</td>
                            <td>₱ {{ number_format($item['selling_price'], 0) }}</td>
                            <td>
                                @if (($updatedQuantities[$item['id']] ?? $item['qty']) == 0)
                                    <span class="text-danger font-weight-bold">Out of Stock</span>
                                @else
                                    {{ $updatedQuantities[$item['id']] ?? $item['qty'] }}
                                @endif
                            </td>
                            <td>
                                <input type="number" class="form-control"
                                    wire:model.defer="quantities.{{ $item['id'] }}" value="1" min="1"
                                    max="{{ $updatedQuantities[$item['id']] ?? $item['qty'] }}"
                                    @if (($updatedQuantities[$item['id']] ?? $item['qty']) == 0) disabled @endif>
                            </td>
                            <td>
                                <button class="btn btn-success btn-block" wire:click="addToCart({{ $item['id'] }})"
                                    @if (($updatedQuantities[$item['id']] ?? $item['qty']) == 0) disabled @endif>
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No result found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- <table class="table table-hover" style="width: 100%" wire:poll.keep-alive>
                <thead>
                    <tr>
                        <th style="width: 10%">Item</th>
                        <th style="width: 10%;">Style code</th>
                        <th style="width: 15%;">Name</th>
                        <th style="width: 7%;">Size</th>
                        <th style="width: 10%;">Price</th>
                        <th style="width: 10%;">Available Qty</th>
                        <th style="width: 10%;">Selected Qty</th>
                        <th style="width: 5%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $item)
                        <tr wire:key={{ $item->id }}>
                            @php
                                $pictures = json_decode($item['picture'], true);
                                $firstPicture = $pictures && count($pictures) > 0 ? $pictures[0] : null;
                            @endphp
                            <td>
                                @if ($firstPicture == null)
                                    <img src="{{ asset('storage/images/default-img.png') }}" width="70"
                                        style="height: 70px !important;" height="70" alt="Default Image"
                                        class="img-thumbnail">
                                @elseif (Storage::exists('public/images/products/' . $firstPicture))
                                    <img src="{{ asset('storage/images/products/' . $firstPicture) }}" width="70"
                                        style="height: 70px !important;" alt="{{ $firstPicture }}"
                                        class="img-thumbnail">
                                @elseif (Storage::exists('public/images/consignments/' . $firstPicture))
                                    <img src="{{ asset('storage/images/consignments/' . $firstPicture) }}"
                                        width="70" style="height: 70px !important;" alt="{{ $firstPicture }}"
                                        class="img-thumbnail">
                                @endif
                            </td>
                            <td>{{ $item['sku'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['size'] }}</td>
                            <td>₱ {{ number_format($item['selling_price'], 0) }}</td>
                            <td>{{ $updatedQuantities[$item['id']] ?? $item['qty'] }}</td>
                            <!-- Display updated quantity -->
                            <td>
                                <input type="number" class="form-control"
                                    wire:model.defer="quantities.{{ $item['id'] }}" value="1" min="1"
                                    max="{{ $updatedQuantities[$item['id']] ?? $item['qty'] }}">
                            </td>
                            <td>
                                <button class="btn btn-success btn-block" wire:click="addToCart({{ $item['id'] }})">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No result found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table> --}}

            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <select class="custom-select form-control" wire:model.live="per_page">
                        <option value="">Select Perpage</option>
                        <option value="3">3</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-9"> {{ $rows->links() }}</div>
            </div>
        </div>
    </div>

    <div class="card-box pd-20 mb-20">
        <h2 class="text-xl mb-4">Cart</h2>

        <!-- Make the cart table scrollable -->
        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
            <table class="table table-hover" style="width: 100%" wire:poll.keep-alive>
                <thead>
                    <tr>
                        <th style="width: 10%">Item</th>
                        <th style="width: 10%;">Style code</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 10%;">Size</th>
                        <th style="width: 10%;">Quantity</th>
                        <th style="width: 10%;">Price</th>
                        <th style="width: 5%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cart as $item)
                        <tr>
                            @php
                                $pictures = json_decode($item['picture'], true);
                                $firstPicture = $pictures && count($pictures) > 0 ? $pictures[0] : null;
                            @endphp
                            <td>
                                @if ($firstPicture == null)
                                    <img src="{{ asset('storage/images/default-img.png') }}" width="70"
                                        style="height: 70px !important;" height="70" alt="Default Image"
                                        class="img-thumbnail">
                                @elseif (Storage::exists('public/images/products/' . $firstPicture))
                                    <img src="{{ asset('storage/images/products/' . $firstPicture) }}" width="70"
                                        style="height: 70px !important;" alt="{{ $firstPicture }}"
                                        class="img-thumbnail">
                                @elseif (Storage::exists('public/images/consignments/' . $firstPicture))
                                    <img src="{{ asset('storage/images/consignments/' . $firstPicture) }}"
                                        width="70" style="height: 70px !important;" alt="{{ $firstPicture }}"
                                        class="img-thumbnail">
                                @endif
                            </td>
                            <td>{{ $item['sku'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['size'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>₱ {{ number_format($item['price'], 0) }}</td>
                            <td>
                                <button class="btn btn-danger btn-block"
                                    wire:click="removeFromCart({{ $item['id'] }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No items in cart</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <hr class="m-2">
    </div>

    <div class="card-box pd-20 mb-20">
        <div>
            <div class="row">
                <div class="col-md-4 col-sm-12 mb-3">
                    <label for=""><b>Amount pay:</b></label>
                    <input type="number" class="form-control" wire:model="amountPay" wire:keyup="updateTotals">
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                    <label for=""><b>Total amount of items:</b></label>
                    <input type="number" class="form-control" wire:model="totalAmount" readonly>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                    <label for=""><b>Total change:</b></label>
                    <input type="number" class="form-control" wire:model="change" readonly>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4 col-sm-12 mb-3">
                    <label for=""><small><b>Customer name:</b></small></label>
                    <input type="text" class="form-control" wire:model="customer_name"
                        placeholder="Enter customer name" required>
                    @error('customer_name')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12 d-flex flex-wrap">
                    <button class="btn btn-success mr-2 mb-2" wire:click="checkout">Proceed to checkout</button>
                    <button class="btn btn-secondary mb-2" wire:click="clearCart">Clear Cart</button>
                </div>
            </div>
        </div>
    </div>

</div>
