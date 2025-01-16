@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Transaction details')
@section('content')
    <div class="invoice-wrap mb-20">
        <div class="invoice-box">
            <div class="invoice-header">
                <div class="logo text-center">
                    {{-- <img src="vendors/images/deskapp-logo.png" alt=""> --}}
                </div>
            </div>
            <h4 class="text-center mb-30 weight-600">Order details</h4>
            <div class="row pb-30">
                <div class="col-md-6">
                    <h5 class="mb-15">{{ $transactionItems->customer_name }}</h5>
                    <p class="font-14 mb-5">
                        Date Issued: <strong
                            class="weight-600">{{ $transactionItems->created_at->format('F d, Y') }}</strong>
                    </p>
                    <p class="font-14 mb-5">
                        Trasaction ID: <strong class="weight-600">{{ $transactionItems->transaction_code }}</strong>
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="text-right">
                        <p class="font-14 mb-5">{{ get_settings()->site_name }}</p>
                        <p class="font-14 mb-5">{{ get_settings()->site_email }}</p>
                        <p class="font-14 mb-5">{{ get_settings()->site_phone }}</p>
                    </div>
                </div>
            </div>
            <div class="invoice-desc pb-30">

                <table class="table" style="margin-bottom: 200px;">
                    <thead class="bg-light">
                        <tr>
                            <th>Item</th>
                            <th>Sku</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($rows as $item)
                            @php
                                $itemTotal = $item->original_price * $item->qty;
                                $total += $itemTotal;
                            @endphp
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['sku'] }}</td>
                                <td>{{ $item['size'] }}</td>
                                <td>{{ number_format($item['original_price']) }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>{{ number_format($itemTotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="invoice-desc-footer">
                    <div class="invoice-desc-head clearfix">
                        <div class="invoice-sub">Order info</div>
                        <div class="invoice-rate">Due By</div>
                        <div class="invoice-subtotal">Sub total</div>
                    </div>
                    <div class="invoice-desc-body">
                        <ul>
                            <li class="clearfix">
                                <div class="invoice-sub">
                                    <p class="font-14 mb-5">

                                        <strong class="weight-600">{{ $transactionItems->transaction_code }}</strong>
                                    </p>
                                    <p class="font-14 mb-5">
                                        Mode of payment: <strong class="weight-600">Cash</strong>
                                    </p>
                                </div>
                                <div class="invoice-rate font-20 weight-600">
                                    {{ $transactionItems->created_at->format('F d, Y') }}
                                </div>
                                <div class="invoice-subtotal">
                                    <span class="weight-600 font-24 text-danger">{{ number_format($total) }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <h4 class="text-center pb-20">Thank You!!</h4>
        </div>
    </div>
@endsection
