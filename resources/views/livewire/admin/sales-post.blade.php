<div>
    <div class="card-box pd-20 mb-20">
        <div class="row mb-30">
            <div class="col-sm-12 col-md-6">
                <div class="search-container">
                    <i class="fa fa-search search-icon"></i>
                    <input type="text" class="form-control" wire:model.live.debounce.300ms="search" placeholder="Search products">
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <select class="custom-select form-control" wire:model.live="filter">
                    <option value="">All</option>
                    <option value="0">Consignment</option>
                    <option value="1">Store</option>
                </select>
            </div>
            <div class="col-sm-12 col-md-3">
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
                        <th style="width: 10%;">Price</th>
                        <th style="width: 10%;">Available Qty</th>
                        <th style="width: 10%;">Selected Qty</th>
                        <th style="width: 5%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $item)
                    <tr>
                        <td>
                            @if ($item->picture == null)
                                <img src="{{ asset('storage/images/default-img.png') }}" width="70" style="height: 70px !important;" height="70" alt="Default Image" class="img-thumbnail">
                            @elseif (Storage::exists('public/images/products/' . $item->picture))
                                <img src="{{ asset('storage/images/products/' . $item->picture) }}" width="70" style="height: 70px !important;" alt="{{ $item->name }}" class="img-thumbnail">
                            @elseif (Storage::exists('public/images/consignments/' . $item->picture))
                                <img src="{{ asset('storage/images/consignments/' . $item->picture) }}" width="70" style="height: 70px !important;" alt="{{ $item->name }}" class="img-thumbnail">
                            @endif
                        </td>
                        <td>{{ $item->sku }}</td>
                        <td>{{ $item->name }}</td>
                        <td>₱ {{ number_format($item->selling_price, 0) }}</td>
                        <td>{{ $item->qty }}</td>
                        <td><input type="number" class="form-control" wire:model.defer="quantities.{{ $item->id }}" value="1"></td>
                        <td><button class="btn btn-success btn-block" wire:click="addToCart({{ $item->id }})"><i class="bi bi-cart-plus"></i></button></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">No result found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <select class="custom-select form-control" wire:model.live="per_page">
                        <option value="">Select Perpage</option>
                        <option value="1">1</option>
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

        <div class="table-responsive">
            <table class="table table-hover" style="width: 100%" wire:poll.keep-alive>
                <thead>
                    <tr>
                        <th style="width: 10%">Item</th>
                        <th style="width: 10%;">Style code</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 10%;">Quantity</th>
                        <th style="width: 10%;">Price</th>
                        <th style="width: 5%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($cart as $productId => $cartItem)
                <tr>
                    <td>
                        @if (isset($cartItem['picture']))
                            @if (Storage::exists('public/images/products/' . $cartItem['picture']))
                                <img src="{{ asset('storage/images/products/' . $cartItem['picture']) }}" width="70" height="70" alt="{{ $cartItem['name'] }}" class="img-thumbnail">
                            @elseif (Storage::exists('public/images/consignments/' . $cartItem['picture']))
                                <img src="{{ asset('storage/images/consignments/' . $cartItem['picture']) }}" width="70" height="70" alt="{{ $cartItem['name'] }}" class="img-thumbnail">
                            @else
                                <img src="{{ asset('storage/images/default-img.png') }}" width="70" height="70" alt="Default Image">
                            @endif
                        @else
                            <img src="{{ asset('storage/images/default-img.png') }}" width="70" height="70" alt="Default Image" class="img-thumbnail">
                        @endif
                    </td>
                    <td>{{ $cartItem['sku'] ?? 'N/A' }}</td>
                    <td>{{ $cartItem['name'] }}</td>
                    <td>{{ $cartItem['qty'] }}</td>
                    <td>₱ {{ number_format($cartItem['total'], 0) }}</td>
                    <td>
                        <button class="btn btn-danger btn-block" wire:click="removeFromCart({{ $productId }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">Your cart is empty.</td>
                </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                <div class="row">
                    <div class="col-4">
                        <label for=""><b>Amount pay:</b></label>
                        <input type="number" class="form-control" wire:model="amountPay" wire:keyup="updateTotals">
                    </div>
                    <div class="col-4">
                        <label for=""><b>Total amount of items:</b></label>
                        <input type="number" class="form-control" wire:model="totalAmount" readonly>
                    </div>
                    <div class="col-4">
                        <label for=""><b>Total change: </b></label>
                        <input type="number" class="form-control" wire:model="change" readonly>
                    </div>
                </div>

                <div class="row mt-2 pd-20">
                    <button class="btn btn-info mr-10" wire:click="store">Create sales</button>
                    <button class="btn btn-secondary" wire:click="clearCart">Clear Cart</button>
                </div>
            </div>

        </div>
    </div>
</div>
