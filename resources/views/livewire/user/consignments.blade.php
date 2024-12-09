<div>
    <div class="card-box mb-20 pd-20">
        <h2 class="h3 mb-4">Pending consignments</h2>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table table-hover stripe styled-table" style="width: 100%;" wire:poll.keep-alive>
                <thead>
                    <tr>
                        <th><b>Item</b></th>
                        <th><b>Sku</b></th>
                        <th><b>Name</b></th>
                        <th><b>Size</b></th>
                        <th><b>Quantity</b></th>
                        <th><b>Status</b></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr wire:key="{{ $product->id }}" wire:click.prevent="viewConsignmentStatus({{ $product->id }})"
                            style="cursor: pointer;">
                            @php
                                $pictures = json_decode($product['image'], true);
                                $firstPicture = $pictures && count($pictures) > 0 ? $pictures[0] : null;
                            @endphp
                            <td>
                                @if ($firstPicture == null)
                                    <img src="{{ asset('storage/images/default-img.png') }}" width="70"
                                        style="height: 70px !important;" height="70" alt="Default Image"
                                        class="img-thumbnail">
                                @elseif (Storage::exists('public/images/requests/' . $firstPicture))
                                    <img src="{{ asset('storage/images/requests/' . $firstPicture) }}" width="70"
                                        style="height: 70px !important;" alt="{{ $firstPicture }}"
                                        class="img-thumbnail">
                                @endif
                            </td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->size }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>
                                <span
                                    class="badge {{ $product->status === 'Pending' ? 'badge-primary' : 'badge-danger' }}">
                                    {{ $product->status }}
                                </span>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ __('No pending consignments found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <hr>
        </div>

        <!-- Pagination and Per Page Control -->
        <div class="row mt-20">
            <div class="col-md-3">

            </div>
            <div class="col-md-9 text-right">
                {{ $products->links() }}
            </div>
        </div>
    </div>
    <div class="card-box mb-20 pd-20">
        <div class="row">
            <!-- Search and Filter -->
            <div class="col-md-3 mb-10">
                <div class="input-group custom">
                    <div class="input-group-prepend custom">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" wire:model.live.debounce.300ms="search"
                        placeholder="Search product name">
                </div>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-3 mb-10">
                <select class="custom-select form-control" wire:model.live="visibility">
                    <option value="">All</option>
                    <option value="public">Selling</option>
                    <option value="private">Not selling</option>
                </select>
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table table-hover stripe styled-table" style="width: 100%;" wire:poll.keep-alive>
                <thead>
                    <tr>
                        <th><b>Item</b></th>
                        <th><b>Sku</b></th>
                        <th><b>Name</b></th>
                        <th><b>Size</b></th>
                        <th><b>Quantity</b></th>
                        <th><b>Status</b></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inventories as $item)
                        <tr wire:key="{{ $item->id }}" style="cursor: pointer;">
                            @php
                                $pictures = json_decode($item['picture'], true);
                                $firstPicture = $pictures && count($pictures) > 0 ? $pictures[0] : null;
                            @endphp
                            <td>
                                @if ($firstPicture == null)
                                    <img src="{{ asset('storage/images/default-img.png') }}" width="70"
                                        style="height: 70px !important;" height="70" alt="Default Image"
                                        class="img-thumbnail">
                                @elseif (Storage::exists('public/images/consignments/' . $firstPicture))
                                    <img src="{{ asset('storage/images/consignments/' . $firstPicture) }}"
                                        width="70" style="height: 70px !important;" alt="{{ $firstPicture }}"
                                        class="img-thumbnail">
                                @endif
                            </td>
                            <td>{{ $item->sku }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->size }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>
                                <span
                                    class="badge {{ $item->visibility === 'public' ? 'badge-success' : 'badge-primary' }}">
                                    {{ $item->visibility === 'public' ? 'Selling' : 'Not selling' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ __('No products found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination and Per Page Control -->
        <div class="row mt-20">
            <div class="col-md-3">
                <select class="custom-select form-control" wire:model.live="per_page">
                    <option value="">Select Per Page</option>
                    <option value="1">1</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            </div>
            <div class="col-md-9 text-right">
                {{ $inventories->links() }}
            </div>
        </div>
    </div>
</div>
