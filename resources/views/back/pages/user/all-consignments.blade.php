@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>All consignments</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('consignor.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            All consignments
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @livewire('user.consignments')

@endsection

<style>
    /* Styling for the table */
    .styled-table tbody tr td {
        border-bottom: 1px solid #ddd;
    }

    .styled-table tbody tr:last-child td {
        border-bottom: none;
        /* Remove the border for the last row */
    }
</style>
