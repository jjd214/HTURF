<div>
    <div class="row d-flex justify-content-between align-items-center">
        <!-- Search and Filter -->
        <div class="col-12 col-md-4">
            <div class="input-group custom">
                <div class="input-group-prepend custom">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" class="form-control" wire:model.live.debounce.300ms="search"
                    placeholder="Payment, Consignor, Ref no.">
            </div>
        </div>
        <div class="col-12 col-md-3 mb-30">
            <select class="custom-select form-control" wire:model.live="status">
                <option value="">All</option>
                <option value="Pending">Pending</option>
                <option value="Notified">Notified</option>
                <option value="Completed">Completed</option>
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover stripe" style="width: 100%;" wire:poll.keep-alive>
            <thead class="">
                <tr>
                    <th style="width: 15%"><b>Payment code</b></th>
                    <th style="width: 10%"><b>Status</b></th>
                    <th style="width: 15%"><b>Date of payment</b></th>
                    <th style="width: 15%"><b>Consignor</b></th>
                    <th style="width: 10%"><b>Quantity sold</b></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $item)
                    <tr style="cursor: pointer;" wire:click.prevent="showPaymentForm({{ $item->id }})"
                        wire:key={{ $item->id }}>
                        <td><small><b>{{ $item->payment_code }}</b></small></td>
                        <td>
                            <span
                                class="badge
                            {{ $item->status == 'Completed' ? 'badge-success' : '' }}
                            {{ $item->status == 'Notified' ? 'badge-warning' : '' }}
                            {{ $item->status == 'Pending' ? 'badge-info' : '' }}
                            {{ $item->status == 'Incomplete' ? 'badge-danger' : '' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>
                            {{ $item->date_of_payment === null ? 'Not yet emailed' : \Carbon\Carbon::parse($item->date_of_payment)->toFormattedDateString() }}
                        </td>
                        <td><i class="fa fa-user-circle fa-sm ml-2"></i>
                            {{ $item->consignor_name }}
                        </td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No result found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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
