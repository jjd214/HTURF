<div>
    <div class="row">
        <!-- Search and Filter -->
        <div class="col-md-3 mb-10">
            <div class="input-group custom">
                <div class="input-group-prepend custom">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" class="form-control" wire:model.live.debounce.300ms="search" placeholder="Search">
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
</div>
