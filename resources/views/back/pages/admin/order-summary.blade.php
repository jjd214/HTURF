@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Order summary')
@section('content')

@php
    $cart = session('cart', []);
    $orderDetails = session('order_summary', []);
@endphp

@if (session('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: 'success',
            title: 'Transaction complete.'
        });
    </script>
@endif

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Order summary</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Order summary
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="{{ route('admin.sales.add-sales') }}" class="btn btn-primary">Back to create sales</a>
        </div>
    </div>
</div>


<div class="invoice-wrap mb-20">
    <div class="invoice-box">
        <div class="invoice-header">
            <div class="logo text-center">
                <img src="vendors/images/deskapp-logo.png" alt="">
            </div>
        </div>
        <h4 class="text-center mb-30 weight-600">Order details</h4>
        <div class="row pb-30">
            <div class="col-md-6">
                <h5 class="mb-15">{{ $orderDetails['customer_name'] }}</h5>
                <p class="font-14 mb-5">
                    Date Issued: <strong class="weight-600">{{ now()->format('F d, Y') }}</strong>
                </p>
                <p class="font-14 mb-5">
                    Trasaction ID: <strong class="weight-600">{{ $orderDetails['transaction_code'] }}</strong>
                </p>
            </div>
            <div class="col-md-6">
                <div class="text-right">
                    <p class="font-14 mb-5">{{ get_settings()->site_name }}</p>
                    <p class="font-14 mb-5">{{ get_settings()->site_email }}</p>
                    <p class="font-14 mb-5">{{ get_settings()->site_phone }}</p>
                </div>
            </div>
        </div>
        <div class="invoice-desc pb-30">
            <div class="invoice-desc-head clearfix">
                <div class="invoice-sub">Item</div>
                <div class="invoice-rate">Price</div>
                <div class="invoice-hours">Quantity</div>
                <div class="invoice-subtotal">Total</div>
            </div>
            <div class="invoice-desc-body">
                <ul>
                @php
                    $total = 0;
                @endphp
                @foreach ($cart as $item)
                {{-- @php
                    $itemTotal = $item->selling_price * $item->qty;
                    $total += $itemTotal;
                @endphp --}}
                <li class="clearfix">
                    <div class="invoice-sub">{{ $item['name'] }}</div>
                    <div class="invoice-rate">{{ number_format($item['price']) }}</div>
                    <div class="invoice-hours">{{ $item['quantity'] }}</div>
                    <div class="invoice-subtotal">
                        <span class="weight-600">{{ number_format($item['price'] * $item['quantity']) }}</span>
                    </div>
                </li>
                @endforeach
                </ul>
            </div>
            <div class="invoice-desc-footer">
                <div class="invoice-desc-head clearfix">
                    <div class="invoice-sub">Order info</div>
                    <div class="invoice-rate">Due By</div>
                    <div class="invoice-subtotal">Sub total</div>
                </div>
                <div class="invoice-desc-body">
                    <ul>
                        <li class="clearfix">
                            <div class="invoice-sub">
                                <p class="font-14 mb-5">

                                    <strong class="weight-600">{{ $orderDetails['transaction_code'] }}</strong>
                                </p>
                                <p class="font-14 mb-5">
                                    Mode of payment: <strong class="weight-600">Cash</strong>
                                </p>
                            </div>
                            <div class="invoice-rate font-20 weight-600">
                                {{ now()->format('F d, Y') }}
                            </div>
                            <div class="invoice-subtotal">
                                <span class="weight-600 font-24 text-danger">{{ number_format($orderDetails['total_amount'], 2) }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <h4 class="text-center pb-20">Thank You!!</h4>
    </div>
</div>

<div id="thermal-receipt" class="thermal-receipt" style="display: none;">
    <h3 class="text-center">{{ get_settings()->site_name }}</h3>
    <p class="text-center">{{ get_settings()->site_email }}</p>
    <p class="text-center">{{ get_settings()->site_phone }}</p>
    <hr>
    <h4 class="text-center">Order Receipt</h4>
    <p class="text-center">Transaction ID: <strong>{{ $orderDetails['transaction_code'] }}</strong></p>
    <p class="text-center">Date: {{ now()->format('F d, Y - h:i A') }}</p>
    <hr>
    <p><strong>Customer:</strong> {{ $orderDetails['customer_name'] }}</p>
    <hr>
    <table style="width: 100%;">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($cart as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['price'], 2) }}</td>
                <td>{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
            </tr>
            @php $total += $item['price'] * $item['quantity']; @endphp
            @endforeach
        </tbody>
    </table>
    <hr>
    <p><strong>Subtotal:</strong> {{ number_format($total, 2) }}</p>
    <p><strong>Total Amount:</strong> {{ number_format($orderDetails['total_amount'], 2) }}</p>
    <p><strong>Payment Method:</strong> Cash</p>
    <hr>
    <p class="text-center">Thank you for your purchase!</p>
    <p class="text-center">Visit us again!</p>
</div>

<button class="btn btn-success mb-20" onclick="printReceipt()">Print as receipt</button>
<button class="btn btn-info mb-20">Print as pdf</button>

@endsection
@push('scripts')
<script>
    function printReceipt() {
        var receiptContent = document.getElementById('thermal-receipt').innerHTML;
        var printWindow = window.open('', '', 'width=320,height=600');
        printWindow.document.write('<html><head><title>Print Receipt</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('body { font-family: monospace; font-size: 12px; text-align: center; margin: 0; padding: 10px; }');
        printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 5px; }');
        printWindow.document.write('table th, table td { text-align: left; padding: 4px 0; }');
        printWindow.document.write('th { font-weight: bold; }');
        printWindow.document.write('hr { border: none; border-top: 1px dashed #000; margin: 10px 0; }');
        printWindow.document.write('</style></head><body>');
        printWindow.document.write(receiptContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
</script>
@endpush
