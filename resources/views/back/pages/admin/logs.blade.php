@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Logs')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Logs</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Logs
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card-box pd-20 mb-20">
        <iframe src="/admin/log-viewer" frameborder="0" title="Logs"
            style="width: 100%; height: 600px; border: none; border-radius: 7px;">
        </iframe>
    </div>
@endsection
