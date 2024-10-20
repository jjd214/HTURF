<div>
    <div class="invoice-wrap mb-20">
        <div class="invoice-box">
            <div class="invoice-header">
                <div class="logo text-center">
                    <img src="vendors/images/deskapp-logo.png" alt="">
                </div>
            </div>
            <h4 class="text-center mb-30 weight-600">INVOICE</h4>
            <div class="row pb-30">
                <div class="col-md-6">
                    <h5 class="mb-15">{{ session('order_summary.customer_name') }}</h5>
                    <p class="font-14 mb-5">
                        Date Issued: <strong class="weight-600">{{ now()->format('F d, Y') }}</strong>
                    </p>
                    <p class="font-14 mb-5">
                        Invoice No: <strong class="weight-600">{{ session('order_summary.invoice_number') }}</strong>
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
                <div class="invoice-desc-head clearfix">
                    <div class="invoice-sub">Item</div>
                    <div class="invoice-rate">Price</div>
                    <div class="invoice-hours">Quantity</div>
                    <div class="invoice-subtotal">Subtotal</div>
                </div>
                <div class="invoice-desc-body">
                    <ul>
                    @foreach (session('order_summary.cart', []) as $item)
                    <li class="clearfix">
                        <div class="invoice-sub">{{ $item['name'] }}</div>
                        <div class="invoice-rate">{{ number_format($item['price']) }}</div>
                        <div class="invoice-hours">{{ $item['qty'] }}</div>
                        <div class="invoice-subtotal">
                            <span class="weight-600">{{ number_format($item['price'] * $item['qty']) }}</span>
                        </div>
                    </li>
                    @endforeach
                    </ul>
                </div>
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
                                        Transaction id:
                                        <strong class="weight-600">123 456 789</strong>
                                    </p>
                                    <p class="font-14 mb-5">
                                        Order id: <strong class="weight-600">4556</strong>
                                    </p>
                                </div>
                                <div class="invoice-rate font-20 weight-600">
                                    {{ now()->format('F d, Y') }}
                                </div>
                                <div class="invoice-subtotal">
                                    <span class="weight-600 font-24 text-danger">{{ '₱' . number_format(session('order_summary.total_amount')) }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <h4 class="text-center pb-20">Thank You!!</h4>
        </div>
    </div>
    <button class="btn btn-lg btn-success mb-20" wire:click.prevent="store">Place order</button>
</div>
