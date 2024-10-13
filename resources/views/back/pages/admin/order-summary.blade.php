@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Order summary')
@section('content')
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

<div class="card-box pd-20 mb-20">
    <!-- Customer & Payment Details -->
    <h3 class="text-center">HypeArchivePh</h3>
    <p class="text-center"><small>hypearchiveph@gmail.com</small></p>
    <p class="text-center"><small>09394331559</small></p>

    <div class="row">
        <div class="col-md-4">
            <p><strong>Invoice details</strong></p>
            <p><small>Invoice no: INV-123456</small></p>
            <p><small>Invoice date: September 18 2024</small></p>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <p><strong>Customer details</strong></p>
            <p><small>Customer name: Marco Gador</small></p>
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
                <tr>
                    <td>12345</td>
                    <td>Kobe mambacita</td>
                    <td>3000</td>
                    <td>2</td>
                    <td>6000</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"><strong>Sub total: </strong></td>
                    <td>6000</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"><strong>Commision: </strong></td>
                    <td>450</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"><strong>Total: </strong></td>
                    <td>5550</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"><strong>Amount pay:</strong></td>
                    <td>7000</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"><strong>Amount change:</strong></td>
                    <td>500</td>
                </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-4">
                <p><strong>Mode of payment: </strong>Cash</p>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <button class="btn btn-info btn-sm">Save</button>
                <button class="btn btn-success btn-sm">Invoice</button>
            </div>
        </div>
    </div>
</div>
@endsection
