@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Order summary')
@section('content')
@if (!session()->has('order_summary'))
    <script>window.location = "{{ route('admin.sales.add-sales') }}"</script>
@endif


<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Order summary</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Order summary
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="{{ route('admin.sales.add-sales') }}" class="btn btn-primary">Back to create sales</a>
        </div>
    </div>
</div>

<livewire:admin.order-summary />

@endsection
@push('scripts')
<script>
    window.addEventListener('beforeunload', event => {
        Livewire.dispatch('removeOrderSummary');
    });
    function printInvoice() {
        // Create a new window
        var printWindow = window.open('', '_blank');

        // Get the content of the current invoice
        var invoiceContent = document.querySelector('.card-box').innerHTML;

        // Build the complete HTML for the new window
        printWindow.document.write(`
            <html>
                <head>
                    <title>Invoice</title>
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
                    <style>
                        @media print {
                            body {
                                -webkit-print-color-adjust: exact; /* Preserve colors */
                            }
                        }
                    </style>
                </head>
                <body onload="window.print();window.close();">
                    <div class="container">
                        ${invoiceContent}
                    </div>
                </body>
            </html>
        `);

        // Close the document to trigger rendering
        printWindow.document.close();
    }
</script>
@endpush
