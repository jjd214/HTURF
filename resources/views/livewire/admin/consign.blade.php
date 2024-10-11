<div>
    <div class="row">
        <!-- Search and Filter -->
        <div class="col-md-3 mb-10">
            <div class="input-group custom">
                <div class="input-group-prepend custom">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" class="form-control" wire:model.live.debounce.300ms="search" placeholder="Search consign name">
            </div>
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-3 mb-10">
            <select class="custom-select form-control" wire:model.live="visibility">
                <option value="">All</option>
                <option value="public">Public</option>
                <option value="private">Private</option>
            </select>
        </div>
    </div>

    <!-- Responsive Table -->
    <div class="table-responsive">
        <table class="table table-hover stripe" style="width: 100%;" wire:poll.keep-alive>
            <thead class="">
                <tr>
                    <th style="width: 10%"><b>Item</b></th>
                    <th
                        class="sorting"
                        wire:click="setSortBy('sku')"
                        style="width: 15%; cursor: pointer;">
                        <b>Style Code</b>
                        <i class="fa fa-arrow-up"
                           style="{{ $sortBy === 'sku' && $sortDir === 'ASC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                        <i class="fa fa-arrow-down"
                           style="{{ $sortBy === 'sku' && $sortDir === 'DESC' ? 'color: #007bff;' : 'color: #000;' }}">
                        </i>
                    </th>
                    <th
                        class="sorting"
                        wire:click="setSortBy('name')"
                        style="width: 20%; cursor: pointer;">
                        <b>Name</b>
                        <i class="fa fa-arrow-up"
                           style="{{ $sortBy === 'name' && $sortDir === 'ASC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                        <i class="fa fa-arrow-down"
                           style="{{ $sortBy === 'name' && $sortDir === 'DESC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                    </th>
                    <th
                        class="sorting"
                        wire:click="setSortBy('brand')"
                        style="width: 15%; cursor: pointer;">
                        <b>Brand</b>
                        <i class="fa fa-arrow-up"
                           style="{{ $sortBy === 'brand' && $sortDir === 'ASC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                        <i class="fa fa-arrow-down"
                           style="{{ $sortBy === 'brand' && $sortDir === 'DESC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                    </th>
                    <!-- New Expiry Date Column -->
                    <th
                        class="sorting"
                        wire:click="setSortBy('expiry_date')"
                        style="width: 15%; cursor: pointer;">
                        <b>Expiry Date</b>
                        <i class="fa fa-arrow-up"
                           style="{{ $sortBy === 'expiry_date' && $sortDir === 'ASC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                        <i class="fa fa-arrow-down"
                           style="{{ $sortBy === 'expiry_date' && $sortDir === 'DESC' ? 'color: #007bff;' : 'color: #000;' }}"></i>
                    </th>
                    <th style="width: 10%"><b>Visibility</b></th>
                    <th style="width: 10%"><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $item)
                <tr @if($item->expiry_date && \Carbon\Carbon::parse($item->expiry_date)->isPast()) style="opacity: 0.5; pointer-events: none;" @endif>
                    <td>
                        @if ($item->picture === null)
                        <img src="{{ asset('storage/images/default-img.png') }}" width="70" class="img-thumbnail" alt="Default Image">
                        @else
                        <img src="{{ asset('storage/images/consignments/'.$item->picture) }}" width="70" class="img-thumbnail" alt="{{ $item->name }}" style="height: 70px !important;">
                        @endif
                    </td>
                    <td>{{ $item->sku }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>
                        @if ($item->expiry_date)
                            @php
                                $expiryDate = \Carbon\Carbon::parse($item->expiry_date);
                                $today = \Carbon\Carbon::today();
                                $diffInDays = $today->diffInDays($expiryDate);

                                if ($diffInDays > 30) {
                                    $badgeClass = 'badge-info'; // Long-term
                                } elseif ($diffInDays <= 30 && $diffInDays > 7) {
                                    $badgeClass = 'badge-warning'; // Near expiry
                                } elseif ($diffInDays <= 7 && $diffInDays >= 0) {
                                    $badgeClass = 'badge-danger'; // Nearly expired
                                } else {
                                    $badgeClass = 'badge-secondary'; // Expired
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ $expiryDate->format('Y-m-d') }}
                            </span>
                        @else
                            <span class="badge badge-secondary">N/A</span>
                        @endif
                    </td>

                    <td>
                        <span class="badge {{ $item->visibility == 'public' ? 'badge-success' : 'badge-primary' }}">{{ $item->visibility }}</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                <i class="dw dw-more"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" wire:click.prevent="showEditForm({{ $item->id }})"><i class="dw dw-eye"></i> View</a>
                                <a class="dropdown-item" href="javascript:;" wire:click.prevent="delete({{ $item->id }}, '{{ $item->name }}')">
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
