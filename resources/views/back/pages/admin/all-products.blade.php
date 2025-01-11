@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Store products')
@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>All products</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            All products
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-md-right text-sm-left p-2">
                <a href="{{ route('admin.product.add-product') }}" class="btn btn-primary">Add new product</a>
            </div>
        </div>
    </div>

    <div class="card-box mb-20 pd-20">
        @livewire('admin.product')
    </div>

    @livewire('admin.edit-product')

@endsection
@push('scripts')
    <script>
        window.addEventListener('deleteProduct', event => {
            var id = event.detail.id;
            var name = event.detail.name
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
                    Livewire.dispatch('deleteProductHandler', [id]);

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
