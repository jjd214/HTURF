<div>
    <div class="card-box pd-20 mb-20">

        <div class="responsive">
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
                        <tr style="cursor: pointer;" wire:click.prevent="viewPaymentDetails({{ $item['inventoryId'] }})">
                            <td>{{ $item['payment_code'] }}</td>
                            <td> <span class="badge badge-info">{{ $item['status'] }}</span></td>
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
    </div>
</div>
