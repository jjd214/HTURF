@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Payment details')
@section('content')
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
                            <img src="{{ asset('storage/images/default-img.png') }}" alt="Item Image" class="img-thumbnail"
                                style="width: 200px; height: 200px;">
                        @else
                            @php
                                $pictures = json_decode($itemDetails->picture, true);
                                $firstPicture = $pictures && count($pictures) > 0 ? $pictures[0] : null;
                            @endphp
                            <img src="{{ asset('storage/images/consignments/' . $firstPicture) }}" alt="Item Image"
                                class="img-thumbnail" style="width: 100px; height: auto;">
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
                            <img src="{{ asset('images/users/default-avatar.png') }}" alt="user image"
                                class="img-thumbnail" style="width: 100px; height: auto;">
                        @else
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <img src="{{ $consignorDetails['picture'] }}" alt="User image" class="img-thumbnail"
                                    style="width: 100px; height: auto;">
                            </div>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <label for=""><small><b>CONSIGNMENT DETAILS </b></small></label>
                        <p><small><b>Commission Percentage:</b> {{ $consignmentDetails['commission_percentage'] }}</small>
                        </p>
                        <p><small><b>Start Date:</b> {{ $consignmentDetails['start_date'] }}</small></p>
                        <p><small><b>Expiry Date:</b> {{ $consignmentDetails['expiry_date'] }}</small></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Receipt Column -->
        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-4">
            <div class="card-box height-100-p overflow-hidden pd-20 shadow-sm border rounded bg-white">
                @if ($paymentDetails->status === 'Completed')
                    <h6 class="mb-3"><b>Date payed: </b>
                        {{ \Carbon\Carbon::parse($paymentDetails['updated_at'])->format('F j, Y') }}</h6>
                @elseif($paymentDetails->status === 'Notified')
                    <h6 class="mb-3"><b>Date notified: </b>
                        {{ \Carbon\Carbon::parse($paymentDetails['updated_at'])->format('F j, Y') }}</h6>
                @else
                    <h6 class="mb-3"><b>Date purchased: </b>
                        {{ \Carbon\Carbon::parse($paymentDetails['created_at'])->format('F j, Y') }}</h6>
                @endif
                <div class="receipt-content">
                    <p><small><b>Reference number:</b>
                            {{ $paymentDetails['status'] === 'Completed' ? $paymentDetails['reference_no'] ?? 'xxxxxxxxxx' : 'Not yet paid' }}</small>
                    </p>
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
                            <p><small>{{ $itemDetails['name'] }} ({{ $paymentDetails['quantity'] . 'x' }})</small></p>
                        </div>
                        <div class="col-4 text-right">
                            <p><small>{{ number_format($itemDetails['selling_price'] * $paymentDetails['quantity'], 0) }}</small>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p><small>Commission ({{ $consignmentDetails['commission_percentage'] . '%' }})</small></p>
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
                    @if ($paymentDetails['status'] === 'Completed')
                        <p class="text-center"><b>Transaction completed</b></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
