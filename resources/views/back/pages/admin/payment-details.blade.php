@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Payment details')
@section('content')
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
        title: '{{ session('success') }}'
    });
</script>
@endif
@if (session('fail'))
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
        title: '{{ session('fail') }}'
    });
</script>
@endif
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Payment Details</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb p-2 rounded">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}" class="text-decoration-none">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Payment Details
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-md-right text-sm-left">
           <a href="{{ route('admin.payment.all-payments') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Item and Consignor Details Column -->
    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 mb-4">
        <div class="pd-20 card-box height-100-p shadow-sm border rounded bg-white">
            <div class="row">
                <div class="col-md-6">
                    <label for=""><small><b>ITEM DETAILS </b></small></label>
                    <p><small><b>Name:</b> {{ $itemDetails['name'] }}</small></p>
                    <p><small><b>Brand:</b> {{ $itemDetails['brand'] }}</small></p>
                    <p><small><b>Sku:</b> {{ $itemDetails['sku'] }}</small></p>
                    <p><small><b>Color:</b> {{ $itemDetails['color'] }}</small></p>
                    <p><small><b>Price:</b> {{ number_format($itemDetails['selling_price'], 0) }}</small></p>
                    <p><small><b>Quantity:</b> {{ $itemDetails['quantity'] }}</small></p>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    @if ($itemDetails['picture'] === null)
                        <img src="{{ asset('storage/images/default-img.png') }}" alt="Item Image" class="img-thumbnail" style="width: 200px; height: 200px;">
                    @else
                        <img src="{{ asset('storage/images/consignments/'.$itemDetails->picture) }}" alt="Item Image" class="img-thumbnail" style="width: 100px; height: auto;">
                    @endif
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <label for=""><small><b>CONSIGNOR DETAILS </b></small></label>
                    <p><small><b>Name:</b> {{ $consignorDetails['name'] }}</small></p>
                    <p><small><b>Email:</b> {{ $consignorDetails['email'] }}</small></p>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    @if ($consignorDetails['picture'] === null)
                        <img src="{{ asset('images/users/default-avatar.png') }}" alt="user image" class="img-thumbnail" style="width: 100px; height: auto;">
                    @else
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <img src="{{ $consignorDetails['picture'] }}" alt="Item Image" class="img-thumbnail" style="width: 100px; height: auto;">
                    </div>
                    @endif
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <label for=""><small><b>CONSIGNMENT DETAILS </b></small></label>
                    <p><small><b>Commission Percentage:</b> {{ $consignmentDetails['commission_percentage'] }}</small></p>
                    <p><small><b>Start Date:</b> {{ $consignmentDetails['start_date'] }}</small></p>
                    <p><small><b>Expiry Date:</b> {{ $consignmentDetails['expiry_date'] }}</small></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Column -->
    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-4">
        <div class="card-box height-100-p overflow-hidden pd-20 shadow-sm border rounded bg-white">
            @if ($paymentDetails->status === "Completed")
            <h6 class="mb-3"><b>Date payed: </b> {{ \Carbon\Carbon::parse($paymentDetails['updated_at'])->format('F j, Y') }}</h6>
            @elseif($paymentDetails->status === "Notified")
            <h6 class="mb-3"><b>Date notified: </b> {{ \Carbon\Carbon::parse($paymentDetails['updated_at'])->format('F j, Y') }}</h6>
            @else
            <h6 class="mb-3"><b>Date purchased: </b> {{ \Carbon\Carbon::parse($paymentDetails['created_at'])->format('F j, Y') }}</h6>
            @endif
            <div class="receipt-content">
                <p><small><b>Reference number:</b> {{ ($paymentDetails['status'] === "Completed") ? $paymentDetails['reference_no'] ?? "xxxxxxxxxx" : "Not yet paid" }}</small></p>
                <p><small><b>Payment Code:</b> {{ $paymentDetails['payment_code'] }}</small></p>
                <p><small><b>Status:</b>
                    @if ($paymentDetails['status'] === 'Pending')
                        <span class="badge badge-info">{{ $paymentDetails['status'] }}</span>
                    @endif
                    @if ($paymentDetails['status'] === 'Notified')
                        <span class="badge badge-warning">{{ $paymentDetails['status'] }}</span>
                    @endif
                    @if ($paymentDetails['status'] === 'Completed')
                        <span class="badge badge-success">{{ $paymentDetails['status'] }}</span>
                    @endif
                    @if ($paymentDetails['status'] === 'Incomplete')
                        <span class="badge badge-danger">{{ $paymentDetails['status'] }}</span>
                    @endif
                </small></p>
                <hr>

                <!-- Itemized Details -->
                <div class="row">
                    <div class="col-8">
                        <p><small>{{ $itemDetails['name'] }} ({{ $paymentDetails['quantity'].'x' }})</small></p>
                    </div>
                    <div class="col-4 text-right">
                        <p><small>{{ number_format($itemDetails['selling_price'] * $paymentDetails['quantity'], 0) }}</small></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <p><small>Commission ({{ $consignmentDetails['commission_percentage'].'%' }})</small></p>
                    </div>
                    <div class="col-4 text-right">
                        <p><small>-{{ number_format($paymentDetails['tax'], 0) }}</small></p>
                    </div>
                </div>
                <hr>

                <!-- Total Calculation -->
                <div class="row">
                    <div class="col-8">
                        <p><small><b>Subtotal</b></small></p>
                    </div>
                    <div class="col-4 text-right">
                        <p><small><b>{{ number_format($paymentDetails['total'], 0) }}</b></small></p>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-8">
                        <p><small><b>Total</b></small></p>
                    </div>
                    <div class="col-4 text-right">
                        <p><small><b>{{ number_format($paymentDetails['total'], 0) }}</b></small></p>
                    </div>
                </div>
                <hr>
                @if ($paymentDetails['status'] === "Pending")
                <button class="btn btn-info" data-toggle="modal" data-target="#claimPaymentModal">
                    <i class="fa fa-envelope"></i> Email
                </button>

                <!-- Claim Payment Modal -->
                <div class="modal fade" id="claimPaymentModal" tabindex="-1" role="dialog" aria-labelledby="claimPaymentModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="claimPaymentModalLabel">Set Date and Time for Claiming Payment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.payment.send-payment-details') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_id" value="{{ $itemDetails['id'] }}">
                                    <div class="form-group">
                                        <label for="claimDate">Select Date</label>
                                        <input type="date" name="claim_date" id="claimDate" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="claimTime">Select Time</label>
                                        <input type="time" name="claim_time" id="claimTime" class="form-control" required>
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Set Claim Date & Time</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif ($paymentDetails['status'] === "Notified")
                <form action="{{ route('admin.payment.complete-payment-handler') }}" method="POST" class="mb-10">
                    @csrf
                    <input type="hidden" name="payment_id" value="{{ $paymentDetails['id'] }}">
                    <button class="btn btn-success">
                        <i class="fa fa-check me-2"></i> Complete payment
                    </button>
                </form>
                @else
                <p class="text-center mt-10"><small><b>Thank you for your purchase!</b></small></p>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary" onclick="printReceipt()">Print as receipt</button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="thermal-print" id="thermal-receipt" style="display: none;">
    <style>
        .thermal-print {
            width: 250px;
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4em;
            padding: 10px;
        }
        .thermal-print .text-center {
            text-align: center;
        }
        .thermal-print hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        .thermal-print .section {
            margin-bottom: 8px;
        }
        .thermal-print .item-detail, .thermal-print .total-detail {
            display: flex;
            justify-content: space-between;
        }
        .thermal-print .label {
            font-weight: bold;
        }
    </style>

    <!-- Store Details -->
    <div class="section text-center">
        <h3>{{ get_settings()->site_name }}</h3>
        <p>{{ get_settings()->site_email }}</p>
        <p>{{ get_settings()->site_phone }}</p>
    </div>
    <hr>

    <!-- Receipt Header -->
    <div class="section text-center">
        <h4>Payment Receipt</h4>
        <p>Reference No: <strong>{{ $paymentDetails['reference_no'] ?? '123456789' }}</strong></p>
        <p>Date: {{ now()->format('F d, Y - h:i A') }}</p>
    </div>
    <hr>

    <!-- Consignor Details -->
    <div class="section">
        <p><span class="label">Consignor:</span> {{ $consignorDetails['name'] }}</p>
    </div>
    <hr>

    <!-- Item Details -->
    <div class="section">
        <p class="label">Item:</p>
        <div class="item-detail">
            <span><b>Name</b></span>
            <span>{{ $itemDetails['name'] }}</span>
        </div>
        <div class="item-detail">
            <span><b>SKU</b></span>
            <span>{{ $itemDetails['sku'] }}</span>
        </div>
        <div class="item-detail">
            <span><b>Price</b></span>
            <span>{{ number_format($itemDetails['selling_price'], 2) }}</span>
        </div>
        <div class="item-detail">
            <span><b>Quantity</b></span>
            <span>{{ $itemDetails['quantity'] }}</span>
        </div>
        <div class="item-detail">
            <span><b>Subtotal</b></span>
            <span>{{ number_format($itemDetails['selling_price'] * $itemDetails['quantity'], 2) }}</span>
        </div>
        <div class="item-detail">
            <span><b>Tax</b></span>
            <span>{{ number_format($paymentDetails['tax'], 2) }}</span>
        </div>
        <div class="item-detail">
            <span class="label"><b>Total</b></span>
            <span class="label">{{ number_format($paymentDetails['total'], 2) }}</span>
        </div>
    </div>
    <hr>

    <!-- Totals and Payment -->
    <div class="section">
        <div class="total-detail">
            <span class="label"><b>Total Amount:</b></span>
            <span>{{ number_format($paymentDetails['total'], 2) }}</span>
        </div>
        <div class="total-detail">
            <span class="label"><b>Payment Method:</b></span>
            <span>Cash</span>
        </div>
    </div>
    <hr>

    <!-- Footer -->
    <div class="section text-center">
        <p>Thank you for your purchase!</p>
        <p>Visit us again!</p>
    </div>
</div>

@endsection
@push('scripts')
<script>
    function printReceipt() {
        var receiptContent = document.getElementById('thermal-receipt').innerHTML;
        var printWindow = window.open('', '', 'width=320,height=600');
        printWindow.document.write('<html><head><title>Print Receipt</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('body { font-family: monospace; font-size: 12px; text-align: center; margin: 0; padding: 10px; }');
        printWindow.document.write('hr { border: none; border-top: 1px dashed #000; margin: 10px 0; }');
        printWindow.document.write('</head><body>');
        printWindow.document.write(receiptContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
</script>
@endpush
