@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Refund')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Refund</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Refund
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
           <a href="{{ route('admin.product.all-products') }}" class="btn btn-primary">View all refunds</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for=""><b>Item</b></label>
                        <select name="" id="" class="custom-select form-control">
                            <option value="">Product 1</option>
                            <option value="">Product 2</option>
                            <option value="">Product 3</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for=""><b>Quantity</b></label>
                        <input type="number" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for=""><b>Reason for refund</b></label>
                        <textarea name="" id="" class="form-control"></textarea>
                    </div>
                </div>

            </div>
            <button class="btn btn-primary">Confirm</button>
        </div>
    </div>
    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden pd-20">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Samba OG</td>
                        <td>47</td>
                        <td>2</td>
                        <td>9000</td>
                    </tr>
                </tbody>
            </table>

            <button class="btn btn-success">Refund</button>
        </div>
    </div>
</div>
@endsection
