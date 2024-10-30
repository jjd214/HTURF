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
                <option value="Refunded">Refunded</option>
                <option value="Restock">Restock</option>
            </select>
        </div>
    </div>

    <!-- Responsive Table -->
    <div class="table-responsive">
        <table class="table table-hover stripe" style="width: 100%;" wire:poll.keep-alive>
            <thead>
                <tr>
                    <th style="width: 20%"><b>Transaction code</b></th>
                    <th style="width: 10%"><b>Status</b></th>
                    <th style="width: 15%"><b>Date of refund</b></th>
                    <th style="width: 15%"><b>Customer name</b></th>
                    <th style="width: 5%"><b>Quantity</b></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $item)
                <tr style="cursor: pointer;" wire:click="selectRefund({{ $item->id }})" data-toggle="modal" data-target="#refundModal">
                    <td><small><b>{{ $item->transaction_code }}</b></small></td>
                    <td><span class="badge {{ $item->status == 'Refunded' ? 'badge-danger' : 'badge-success' }}">{{ $item->status }}</span></td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->customer_name }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No results found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Enhanced Modal for Viewing Refund Details -->
    <div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title d-flex align-items-center" id="refundModalLabel">
                        <i class="fas fa-receipt mr-2"></i> Refund Details
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @if($selectedRefund)
                    <div class="card p-3 border-0">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong><i class="fa fa-barcode mr-2 text-primary"></i>Transaction Code:</strong>
                                <p class="ml-4 text-muted">{{ $selectedRefund->transaction_code }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <strong><i class="fa fa-info-circle mr-2 text-primary"></i>Status:</strong>
                                <p class="ml-4">
                                    <span class="badge {{ $selectedRefund->status == 'Refunded' ? 'badge-danger' : 'badge-success' }}">
                                        {{ $selectedRefund->status }}
                                    </span>
                                </p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <strong><i class="fa fa-calendar-alt mr-2 text-primary"></i>Date of Refund:</strong>
                                <p class="ml-4 text-muted">{{ $selectedRefund->created_at }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <strong><i class="fa fa-user mr-2 text-primary"></i>Customer Name:</strong>
                                <p class="ml-4 text-muted">{{ $selectedRefund->customer_name }}</p>
                            </div>

                            <!-- Item Details -->
                            <div class="col-md-6 mb-3">
                                <strong><i class="fa fa-cube mr-2 text-primary"></i>Item Details:</strong>
                                @if($selectedInventory)
                                    <p class="ml-4 text-muted"><small><b>Item:</b> {{ $selectedInventory->name }}</small></p>
                                    <p class="ml-4 text-muted"><small><b>Brand:</b> {{ $selectedInventory->brand }}</small></p>
                                    <p class="ml-4 text-muted"><small><b>Size:</b> {{ $selectedInventory->size }}</small></p>
                                    <p class="ml-4 text-muted"><small><b>Color:</b> {{ $selectedInventory->color }}</small></p>
                                @else
                                    <p class="text-muted">No item details available.</p>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <strong><i class="fa fa-box mr-2 text-primary"></i>Quantity:</strong>
                                <p class="ml-4 text-muted">{{ $selectedRefund->quantity }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <strong><i class="fa fa-question-circle mr-2 text-primary"></i>Refund Reason:</strong>
                                <p class="ml-4 text-muted">{{ $selectedRefund->reason_for_refund }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <strong><i class="fa fa-dollar-sign mr-2 text-primary"></i>Refund Amount:</strong>
                                <p class="ml-4 text-muted">${{ number_format($selectedRefund->total_price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <p class="text-center">No details available.</p>
                    @endif
                </div>

                <div class="modal-footer">
                    @if ($selectedRefund && $selectedRefund->status === 'Refunded')
                    <button class="btn btn-success" wire:click.prevent="restock">Restock</button>
                    @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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
