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
                <ol class="breadcrumb bg-light p-2 rounded">
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
                    <p><small><b>Name:</b> Samba OG Sneakers</small></p>
                    <p><small><b>Brand:</b> Adidas</small></p>
                    <p><small><b>Sku:</b> 12345</small></p>
                    <p><small><b>Color:</b> Black and White</small></p>
                    <p><small><b>Price:</b> $5,000</small></p>
                    <p><small><b>Quantity:</b> 2</small></p>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <img src="{{ asset('storage/images/default-img.png') }}" alt="Item Image" class="img-thumbnail" style="width: 200px; height: 200px;">
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <label for=""><small><b>CONSIGNOR DETAILS </b></small></label>
                    <p><small><b>Name:</b> Marco Gador</small></p>
                    <p><small><b>Email:</b> marco@example.com</small></p>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <img src="{{ asset('storage/images/default-img.png') }}" alt="Item Image" class="img-thumbnail" style="width: 100px; height: auto;">
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <label for=""><small><b>CONSIGNMENT DETAILS </b></small></label>
                    <p><small><b>Commission Percentage:</b> 10%</small></p>
                    <p><small><b>Start Date:</b> September 18, 2025</small></p>
                    <p><small><b>Expiry Date:</b> October 18, 2025</small></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Column -->
    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-4">
        <div class="card-box height-100-p overflow-hidden pd-20 shadow-sm border rounded bg-white">
            <h5 class="text-center mb-3"><b>Receipt</b></h5>
            <div class="receipt-content">
                <p><small><b>Date:</b> 2024-10-31</small></p>
                <p><small><b>Payment Code:</b> PAY-13-20241031080632-DXGW</small></p>
                <p><small><b>Transaction Code:</b> PAY-13-20241031080632-DXGW</small></p>
                <hr>

                <!-- Itemized Details -->
                <div class="row">
                    <div class="col-8">
                        <p><small>Samba OG Sneakers (2x)</small></p>
                    </div>
                    <div class="col-4 text-right">
                        <p><small>$10,000</small></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <p><small>Commission (10%)</small></p>
                    </div>
                    <div class="col-4 text-right">
                        <p><small>-$1,000</small></p>
                    </div>
                </div>
                <hr>

                <!-- Total Calculation -->
                <div class="row">
                    <div class="col-8">
                        <p><small><b>Subtotal</b></small></p>
                    </div>
                    <div class="col-4 text-right">
                        <p><small><b>$9,000</b></small></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <p><small>Tax (5%)</small></p>
                    </div>
                    <div class="col-4 text-right">
                        <p><small>$450</small></p>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-8">
                        <p><small><b>Total</b></small></p>
                    </div>
                    <div class="col-4 text-right">
                        <p><small><b>$9,450</b></small></p>
                    </div>
                </div>
                <hr>

                <!-- Payment Details -->
                <p class="text-center"><small><b>Thank you for your purchase!</b></small></p>
            </div>
        </div>
    </div>
</div>
@endsection
