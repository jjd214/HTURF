<div>
    <div class="row d-flex justify-content-between align-items-center">
        <!-- Search and Filter -->
        <div class="col-12 col-md-4">
            <div class="input-group custom">
                <div class="input-group-prepend custom">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" class="form-control" wire:model.live.debounce.300ms="search"
                    placeholder="Search transactions">
            </div>
        </div>
        <div class="col-12 col-md-3 mb-30">
            <select class="custom-select form-control" wire:model.live="visibility">
                <option value="">All</option>
                <option value="public">In stock</option>
            </select>
        </div>
    </div>

    <!-- Responsive Table -->
    <div class="table-responsive">
        <table class="table table-hover stripe" wire:poll.keep-alive>
            <thead>
                <tr>
                    <th><b>Item</b></th>
                    <th class="sorting" wire:click="setSortBy('sku')" style="cursor: pointer;">
                        <b>Style Code</b>
                        <i class="fa fa-arrow-up"
                            style="{{ $sortBy === 'sku' && $sortDir === 'ASC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                        <i class="fa fa-arrow-down"
                            style="{{ $sortBy === 'sku' && $sortDir === 'DESC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                    </th>
                    <th class="sorting" wire:click="setSortBy('name')" style="cursor: pointer;">
                        <b>Name</b>
                        <i class="fa fa-arrow-up"
                            style="{{ $sortBy === 'name' && $sortDir === 'ASC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                        <i class="fa fa-arrow-down"
                            style="{{ $sortBy === 'name' && $sortDir === 'DESC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                    </th>
                    <th class="sorting" wire:click="setSortBy('brand')" style="cursor: pointer;">
                        <b>Brand</b>
                        <i class="fa fa-arrow-up"
                            style="{{ $sortBy === 'brand' && $sortDir === 'ASC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                        <i class="fa fa-arrow-down"
                            style="{{ $sortBy === 'brand' && $sortDir === 'DESC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                    </th>
                    <th><b>Size</b></th>
                    <th><b>Status</b></th> <!-- Added Status Column -->
                    <th><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $item)
                    <tr wire:key="{{ $item->id }}">
                        <td>
                            @php
                                // Decode the picture array from JSON
                                $pictures = json_decode($item->picture, true);
                                // Get the first picture if available
                                $firstPicture = $pictures && count($pictures) > 0 ? $pictures[0] : null;
                            @endphp

                            @if ($firstPicture === null)
                                <img src="{{ asset('storage/images/default-img.png') }}" width="70"
                                    class="img-thumbnail" alt="Default Image">
                            @else
                                <img src="{{ asset('storage/images/products/' . $firstPicture) }}" width="70"
                                    class="img-thumbnail" alt="{{ $item->name }}" style="height: 70px !important;">
                            @endif
                        </td>

                        <td>{{ $item->sku }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->brand }}</td>
                        <td>{{ $item->size }}</td>
                        <td>
                            @if ($item->qty == 0)
                                <span class="badge badge-danger">Out of Stock</span>
                            @else
                                <span class="badge badge-success">In Stock</span>
                            @endif
                        </td>
                        <td>
                            <div wire:ignore class="dropdown">
                                <a class="btn btn-link dropdown-toggle" href="javascript:;" role="button"
                                    data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"
                                        wire:click.prevent="showEditForm({{ $item->id }})"><i
                                            class="dw dw-eye"></i> View</a>
                                    <a class="dropdown-item" href="javascript:;"
                                        wire:click.prevent="delete({{ $item->id }}, '{{ $item->name }}')">
                                        <i class="dw dw-delete-3"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No products found.</td>
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
            {{ $rows->links() }}
        </div>
    </div>
</div>
