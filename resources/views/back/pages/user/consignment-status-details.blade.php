@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Consignment details')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Consignment details</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('consignor.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Consignment details
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="{{ route('consignor.consignment.all-consignments') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>

    <div class="card-box pd-20 mb-20">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""><b>Product name</b> </label>
                    <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""><b>Brand name</b> </label>
                    <input type="text" class="form-control" value="{{ $product->brand }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""><b>Style code (SKU)</b>
                    </label>
                    <input type="text" class="form-control" value="{{ $product->sku }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""><b>Color way</b> </label>
                    <input type="text" class="form-control" value="{{ $product->colorway }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""><b>Size</b> </label>
                    <input type="number" class="form-control" value="{{ $product->size }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""><b>Product description</b> </label>
                    <input type="text" class="form-control" value="{{ $product->description }}" readonly>
                </div>
            </div>
            <hr>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""><b>Sex</b> </label>
                    <input type="text" class="form-control" value="{{ $product->sex }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""><b>Quantity </b> </label>
                    <input type="number" class="form-control" value="{{ $product->quantity }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for=""><b>Condition </b> </label>
                    <input type="text" class="form-control" value="{{ $product->condition }}" readonly>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for=""><b>Purchase price </b> </label>
                    <input type="text" class="form-control" value="{{ $product->purchase_price }}" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for=""><b>Selling price </b> </label>
                    <input type="text" class="form-control" value="{{ $product->selling_price }}" readonly>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for=""><b>Consignor commission % </b> </label>
                    <input type="text" class="form-control" value="{{ $product->consignor_commission }}" readonly>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for=""><b>Pullout date </b> </label>
                    <input type="text" class="form-control" value="{{ $product->pullout_date }}" readonly>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for=""><b>Status: </b></label>
                    <input type="text" class="form-control mb-10" value="{{ $product->status }}" readonly>
                    <label for=""><b>Consign image: </b> </label>
                </div>
                <div
                    style="width: 100%; height: 100px; border: 1px solid grey; margin-top: -25px; border-radius: 7px; overflow: auto; padding: 10px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-start">
                                @php
                                    $images = $product->image ? json_decode($product->image, true) : [];
                                @endphp
                                @foreach ($images as $image)
                                    <img src="{{ Storage::url('images/requests/' . trim($image, '[]"')) }}"
                                        class="img-thumbnail" style="width: 80px; height: 80px; margin-right: 10px;">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for=""><b>Note </b> </label>
                    <textarea class="form-control" value="{{ $product->note }}" readonly></textarea>
                </div>
            </div>
        </div>
    </div>
@endsection
