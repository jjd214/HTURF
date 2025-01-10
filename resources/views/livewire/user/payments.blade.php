<div>
    <div class="card-box pd-20 mb-20">
        <div class="row d-flex justify-content-between align-items-center">
            <!-- Search and Filter -->
            <div class="col-12 col-md-4">
                <div class="input-group custom">
                    <div class="input-group-prepend custom">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" wire:model.live.debounce.300ms="search"
                        placeholder="Payment, Reference no.">
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><b>Payment code</b></th>
                        <th><b>Status</b></th>
                        <th><b>Date of Payment</b></th>
                        <th><b>Quantity sold</b></th>
                        <th><b>Item</b></th>
                        <th><b>Sku</b></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $item)
                        <tr style="cursor: pointer;" wire:click.prevent="showPaymentForm({{ $item['paymentId'] }})">
                            <td><small><b>{{ $item['payment_code'] }}</b></small></td>
                            <td>
                                <span
                                    class="badge
                                    {{ $item['status'] == 'Pending'
                                        ? 'badge-info'
                                        : ($item['status'] == 'Notified'
                                            ? 'badge-warning'
                                            : 'badge-success') }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                            <td>{{ $item['date_of_payment'] ?? 'No schedule yet' }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['sku'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ __('No payments found.') }}</td>
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
</div>
