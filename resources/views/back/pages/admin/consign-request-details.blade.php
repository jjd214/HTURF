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

{{ $id }}
@endsection
