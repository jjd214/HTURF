@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'All consignments')
@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>All Consignments</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        All Consignments
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
           <a href="{{ route('admin.consignment.add-consign') }}" class="btn btn-primary">Add new consignment</a>
        </div>
    </div>
</div>

<div class="mb-20" >
    <ul>
        <li><small><span class="badge badge-success">Expiry date</span> : 30 Days to expired</small></li>
        <li><small><span class="badge badge-warning">Expiry date</span> : 14 Days to expired</small> </li>
        <li><small><span class="badge badge-danger">Expiry date</span> : Below 7 days to expired</small> </li>
        <li><small><span class="badge badge-secondary">Expiry date</span> : Expired</small> </li>
    </ul>
</div>

<div class="card-box mb-20 pd-20">
    @livewire('admin.consign')
</div>

@livewire('admin.consign-edit')

@endsection
@push('scripts')
<script>
    window.addEventListener('deleteConsign', event => {
        var id = event.detail.id;
        var name = event.detail.name;
        Swal.fire({
            title: "Are you sure you want to delete " + name + " ?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteConsignHandler', [id]);

                Swal.fire(
                    'Deleted!',
                     name + ' has been deleted.',
                    'success'
                );
            }
        });
    });
</script>
@endpush
