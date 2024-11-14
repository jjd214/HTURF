@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')

<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Consignment request details</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb p-2 rounded">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}" class="text-decoration-none">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Consignment request details
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-md-right text-sm-left">
           <a href="{{ route('admin.consignment.all-request') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 mb-4">
        <div class="pd-20 card-box height-100-p shadow-sm border rounded bg-white">
            <small class="ml-1"><b>Images</b></small>
            <div class="image-container" style="display: flex; justify-content: start; padding: 5px; border: 1px solid grey; border-radius: 7px; width: 100%; height: 80px; overflow: auto; flex-direction: row; column-gap: 5px; margin-bottom: 10px;">
                <!-- Clickable images -->
                <img src="{{ asset('images/users/default-avatar.png') }}" alt="Image 1" class="img-thumbnail img-clickable">
                <img src="{{ asset('images/users/consignors/USER_IMG_902151731482306673452c2488e1.jpg') }}" alt="Image 2" class="img-thumbnail img-clickable">
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Product name</b></small></label>
                        <input type="text" class="form-control" value="Product name namenamename" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Style code (SKU)</b></small></label>
                        <input type="text" class="form-control" value="209885" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Colorway</b></small></label>
                        <input type="text" class="form-control" value="Blue/White/Red" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Size</b></small></label>
                        <input type="text" class="form-control" value="45" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Sex</b></small></label>
                        <input type="text" class="form-control" value="Unisex" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Condition</b></small></label>
                        <input type="text" class="form-control" value="Brand new" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Quantity</b></small></label>
                        <input type="text" class="form-control" value="10" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Purchase price</b></small></label>
                        <input type="text" class="form-control" value="5,000" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Selling price</b></small></label>
                        <input type="text" class="form-control" value="3,000" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Commission</b></small></label>
                        <input type="text" class="form-control" value="10%" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Pullout date</b></small></label>
                        <input type="text" class="form-control" value="December 25, 2025" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Status</b></small></label>
                        <input type="text" class="form-control" value="Pending" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for=""><small><b>Product description</b></small></label>
                        <textarea class="form-control" @readonly(true)>lorem ipsum</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for=""><small><b>Consignor's note</b></small></label>
                        <textarea class="form-control" @readonly(true)>lorem ipsum</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-4">
        <div class="card-box pd-20 fixed-height-card overflow-hidden">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-center mb-2">
                        <!-- Clickable profile picture -->
                        <img src="{{ asset('images/users/default-avatar.png') }}" alt="Profile Picture" class="img-thumbnail border-radius-100 img-clickable">
                    </div>
                    <h5 class="text-center h5 mb-0" id="adminProfileName">Marco Gador</h5>
                    <p class="text-center text-muted font-14" id="adminProfileEmail">
                        mgador53@gmail.com
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex mb-20">
    <button class="btn btn-success mr-2">
        <i class="fa fa-check-circle"></i> Accept
    </button>
    <button class="btn btn-danger">
        <i class="fa fa-times-circle"></i> Reject
    </button>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid rounded" alt="Image Preview">
            </div>
        </div>
    </div>
</div>

@endsection

<script>
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const clickableImages = document.querySelectorAll('.img-clickable');

    clickableImages.forEach(img => {
        img.addEventListener('click', function() {
            modalImage.src = this.src;
            $(modal).modal('show'); // Use jQuery to show the Bootstrap modal
        });
    });
});
</script>
