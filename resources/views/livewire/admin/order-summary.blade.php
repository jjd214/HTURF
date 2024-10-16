<div>
    <div class="card-box pd-20 mb-20">
        <!-- Customer & Payment Details -->
        <h3 class="text-center">HypeArchivePh</h3>
        <p class="text-center"><small>hypearchiveph@gmail.com</small></p>
        <p class="text-center"><small>09394331559</small></p>

        <div class="row">
            <div class="col-md-4">
                <p><strong>Invoice details</strong></p>
                <p><small>Invoice no: {{ session('order_summary.invoice_number') }}</small></p>
                <p><small>Invoice date: {{ now()->format('F d, Y') }}</small></p>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <p><strong>Customer details</strong></p>
                <p><small>Customer name: {{ session('order_summary.customer_name') }}</small></p>
            </div>
        </div>

        <div class="table-responsive" style="margin-top: 25px;">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Style code</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (session('order_summary.cart', []) as $item)
                        <tr>
                            <td>{{ $item['sku'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ '₱' . number_format($item['price']) }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td>{{ '₱' . number_format($item['total']) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-right"><strong>Sub total: </strong></td>
                        <td>{{ '₱' . number_format(session('order_summary.total_amount')) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Commission: </strong></td>
                        <td>{{ '₱' . number_format(session('order_summary.commission')) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total: </strong></td>
                        <td>{{ '₱' . number_format(session('order_summary.total_amount') - session('order_summary.commission')) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Amount pay:</strong></td>
                        <td>{{ '₱' . number_format(session('order_summary.amount_pay')) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Amount change:</strong></td>
                        <td>{{ '₱' . number_format(session('order_summary.change')) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-4">
                    <p><strong>Mode of payment: </strong>Cash</p>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <button class="btn btn-info btn-sm" wire:click.prevent="store">Save</button>
                    <button class="btn btn-primary btn-sm" onclick="printInvoice()">Invoice</button>
                </div>
            </div>
        </div>
    </div>
</div>
