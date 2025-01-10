<div>
    <div class="row d-flex justify-content-between align-items-center">
        <!-- Search and Filter -->
        <div class="col-12 col-md-4">
            <div class="input-group custom">
                <div class="input-group-prepend custom">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" class="form-control" wire:model.live.debounce.300ms="search" placeholder="Search">
            </div>
        </div>
        <div class="col-12 col-md-3 mb-30">
            <select class="custom-select form-control" wire:model.live="status">
                <option value="">All</option>
                <option value="Pending">Pending</option>
                <option value="Rejected">Rejected</option>
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover striped" wire:poll.keep-alive>
            <thead>
                <tr>
                    <th><b>Item</b></th>
                    <th><b>Sku</b></th>
                    <th><b>Product</b></th>
                    <th><b>Condition</b></th>
                    <th><b>Consignor name</b></th>
                    <th><b>status</b></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $item)
                    <tr wire:key={{ $item->id }} style="cursor: pointer;"
                        wire:click.prevent="requestDetails({{ $item->id }})">
                        @php
                            $picture = json_decode($item->image, true);
                            $firstPicture = $picture && count($picture) > 0 ? $picture[0] : null;
                        @endphp
                        <td>
                            @if ($firstPicture === null)
                                <img src="{{ asset('storage/images/default-img.png') }}" width="70"
                                    class="img-thumbnail" alt="Default Image">
                            @else
                                <div class="position-relative">
                                    <img src="{{ asset('storage/images/requests/' . $firstPicture) }}" width="70"
                                        class="img-thumbnail" alt="{{ $item->name }}"
                                        style="height: 70px !important;">

                                </div>
                            @endif
                        </td>
                        <td>{{ $item->sku }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->condition }}</td>
                        <td>{{ $item->consignorName }}</td>
                        <td>
                            <span
                                class="badge {{ $item->status == 'Pending' ? 'badge-info' : ($item->status == 'Approved' ? 'badge-success' : 'badge-danger') }}">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">{{ __('No consignment request found.') }}</td>
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
