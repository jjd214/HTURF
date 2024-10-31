<div>
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
                <tr style="cursor: pointer;" wire:click.prevent="showPaymentForm({{ $item->id }})">
                    <td><small><b>{{ $item->payment_code }}</b></small></td>
                    <td><span class="badge {{ $item->status == 'Pending' ? 'badge-info' : 'badge-danger' }}">{{ $item->status }}</span></td>
                    <td>{{ ($item->date_of_payment === null) ? 'Not yet emailed' : $item->date_of_payment }}</td>
                    <td><i class="fa fa-user-circle fa-sm ml-2"></i>
                        {{ $item->consignor_name }}
                    </td>
                    <td>{{ $item->quantity }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">No result found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
