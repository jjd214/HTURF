@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Consignment</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('consignor.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Apply for consignment
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box pd-20 mb-20">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><b>Product name</b> </label>
                <input type="text" class="form-control" placeholder="Enter product name">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><b>Brand name</b> </label>
                <input type="text" class="form-control" placeholder="Enter brand name">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><b>Style code (SKU)</b> </label>
                <input type="text" class="form-control" placeholder="Enter sku">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><b>Color way</b> </label>
                <input type="text" class="form-control" placeholder="Enter colorway">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><b>Size</b> </label>
                <input type="number" class="form-control" placeholder="Enter size">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><b>Product description</b> </label>
                <input type="text" class="form-control" placeholder="Enter short product description (Optional)">
            </div>
        </div>
        <hr>
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><b>Sex </b> </label>
                <input type="text" class="form-control" placeholder="Enter sex">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><b>Quantity </b> </label>
                <input type="number" class="form-control" placeholder="Enter quantity">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><b>Status </b> </label>
                <select class="form-control" id="">
                    <option value="Brand new">Brand new</option>
                    <option value="Used">Used</option>
                    <option value="Slightly used">Sligthly used</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for=""><b>Purchase price </b> </label>
                <input type="text" class="form-control" placeholder="Enter purchase price">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for=""><b>Selling price </b> </label>
                <input type="text" class="form-control" placeholder="Enter selling price">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for=""><b>Consignor commission % </b> </label>
                <input type="text" class="form-control" placeholder="Enter consignor commission">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for=""><b>Pullout date </b> </label>
                <input type="date" class="form-control" placeholder="Enter pullout date">
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for=""><b>Consign image </b> </label>
                <input type="file" class="form-control" placeholder="Image">
                <span><small class="pd-5">You can select multiple image</small></span>
            </div>
            <div style="width: 100%; height: 100px; border: 1px solid grey; margin-top: -10px; border-radius: 7px;">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for=""><b>Note </b> </label>
                <textarea class="form-control" placeholder="Note to consignor (Optional)"></textarea>
            </div>
        </div>
    </div>
</div>

<button class="btn btn-success mb-20">Submit</button>
@endsection
