<div>
    <div class="row">
        <!-- Search and Filter -->
        <div class="col-md-4 mb-10">
            <div class="input-group custom">
                <div class="input-group-prepend custom">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" class="form-control" wire:model.live.debounce.300ms="search" placeholder="Search transactions">
            </div>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-3 mb-10">
            <select class="custom-select form-control" wire:model.live="status">
                <option value="">All</option>
                <option value="Completed">Completed</option>
                <option value="Refunded">Refunded</option>
            </select>
        </div>
    </div>

    <!-- Responsive Table -->
    <div class="table-responsive">
        <table class="table table-hover stripe" style="width: 100%;" wire:poll.keep-alive>
            <thead class="">
                <tr>
                    <th style="width: 20%"><b>Transaction code</b></th>
                    <th style="width: 10%"><b>Status</b></th>
                    <th style="width: 10%"><b>Date</b></th>
                    <th style="width: 15%"><b>Customer</b></th>
                    <th style="width: 5%"><b>Quantity</b></th>
                    <th style="width: 10%"><b>Total amount</b></th>
                    <th style="width: 5%"><b></b></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $item)
                <tr>
                    <td><small><b>{{ $item->transaction_code }}</b></small></td>
                    <td><span class="badge {{ $item->status == 'Completed' ? 'badge-success' : 'badge-danger' }}">{{ $item->status }}</span></td>
                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                    <td><i class="fa fa-user-circle fa-sm ml-2"></i>
                        {{ $item->customer_name }}</td>
                    <td>{{ $item->quantity_sold }}</td>
                    <td>{{ number_format($item->total_amount) }}</td>
                    <td>
                        <div wire:ignore class="dropdown">
                            <a class="btn btn-link dropdown-toggle" href="javascript:;" role="button" data-toggle="dropdown">
                                <i class="dw dw-more"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('admin.sales.transaction-details', ['transaction_code' => $item->transaction_code]) }}" ><i class="dw dw-eye"></i> View</a>
                                <a class="dropdown-item" href="{{ route('admin.sales.transaction-details', ['transaction_code' => $item->transaction_code]) }}" ><i class="dw dw-money"></i> Refund</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No result found.</td>
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
            {{-- {{ $rows->links() }} --}}
        </div>
    </div>
</div>
