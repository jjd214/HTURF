@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
@if (session('info'))
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
            icon: 'info',
            title: '{{ session('info') }}'
        });
    </script>
@endif
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
                @php $images = json_decode($consignmentRequestDetails->image, true); @endphp
                @foreach ($images as $image)
                    <img src="{{ Storage::url('images/requests/' . trim($image, '[]"')) }}" class="img-thumbnail img-clickable" style="cursor: pointer;">
                @endforeach
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Product name</b></small></label>
                        <input type="text" class="form-control" value="{{ $consignmentRequestDetails['name'] }}" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Style code (SKU)</b></small></label>
                        <input type="text" class="form-control" value="{{ $consignmentRequestDetails['sku'] }}" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Colorway</b></small></label>
                        <input type="text" class="form-control" value="{{ $consignmentRequestDetails['colorway'] }}" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Size</b></small></label>
                        <input type="text" class="form-control" value="{{ $consignmentRequestDetails['size'] }}" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Sex</b></small></label>
                        <input type="text" class="form-control" value="{{ $consignmentRequestDetails['sex'] }}" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Condition</b></small></label>
                        <input type="text" class="form-control" value="{{ $consignmentRequestDetails['condition'] }}" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Quantity</b></small></label>
                        <input type="text" class="form-control" value="{{ $consignmentRequestDetails['quantity'] }}" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Purchase price</b></small></label>
                        <input type="text" class="form-control" value="{{ $consignmentRequestDetails['purchase_price'] }}" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Selling price</b></small></label>
                        <input type="text" class="form-control" value="{{ $consignmentRequestDetails['selling_price'] }}" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Commission</b></small></label>
                        <input type="text" class="form-control" value="{{ number_format($consignmentRequestDetails['consignor_commission'],0) }}%" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Pullout date</b></small></label>
                        <input type="text" class="form-control" value="{{  \Carbon\Carbon::parse($consignmentRequestDetails['pullout_date'])->toFormattedDateString() }}" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for=""><small><b>Status</b></small></label>
                        <input type="text" class="form-control" value="{{ $consignmentRequestDetails['status'] }}" @readonly(true)>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for=""><small><b>Product description</b></small></label>
                        <textarea class="form-control" @readonly(true)>{{ $consignmentRequestDetails['product_description'] ? $consignmentRequestDetails['product_description'] : "No product description" }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for=""><small><b>Consignor's note</b></small></label>
                        <textarea class="form-control" @readonly(true)>{{ $consignmentRequestDetails['note'] ? $consignmentRequestDetails['note'] : "No note" }}</textarea>
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
                        <img src="{{ $consignorDetails['picture'] }}" alt="Profile Picture" class="img-thumbnail border-radius-100 img-clickable" style="height: 200px; width: 200px; cursor: pointer;">
                    </div>
                    <h5 class="text-center h5 mb-0" id="adminProfileName">{{ $consignorDetails['name'] }}</h5>
                    <p class="text-center text-muted font-14" id="adminProfileEmail">
                        {{ $consignorDetails['email'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="accept-form" action="{{ route('admin.consignment.accept-consignment-request', $consignmentRequestDetails['id']) }}" method="POST" style="display:none;">
    @csrf
    @method('POST')
</form>

<form id="reject-form" action="{{ route('admin.consignment.reject-consignment-request', $consignmentRequestDetails['id']) }}" method="POST" style="display:none;">
    @csrf
    @method('POST')
</form>

<div class="d-flex mb-20">
    <button onclick="confirmAction('accept')" class="btn btn-success mr-2">
        <i class="fa fa-check-circle"></i> Accept
    </button>
    <button onclick="confirmAction('reject')" class="btn btn-danger">
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

    function confirmAction(action) {
        let formId = action === 'accept' ? '#accept-form' : '#reject-form';
        let actionText = action === 'accept' ? 'Accept' : 'Reject';

        Swal.fire({
            title: 'Are you sure?',
            text: `This action cannot be undone. Do you want to ${actionText} this consignment request?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, ${actionText.toLowerCase()} it!`
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(formId).submit();
            }
        });
    }
    </script>
