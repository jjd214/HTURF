<div>
    <div class="row">
        <!-- Pending Payments -->
        <div class="col-xl-6 col-lg-6 col-md-12 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ number_format($total_payouts_claimed, 0) }}</div>
                        <div class="font-14 text-secondary weight-500">Total Payouts Claimed</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#d35400">
                            <i class="icon-copy fa fa-credit-card text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Notified -->
        <div class="col-xl-6 col-lg-6 col-md-12 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ number_format($total_expected_payouts, 0) }}</div>
                        <div class="font-14 text-secondary weight-500">Total Expected Payouts</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#8e44ad">
                            <i class="icon-copy fa fa-clock-o text-white"></i>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row pb-10">
        <!-- Total Payouts Claimed -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ $total_pending_items }}</div>
                        <div class="font-14 text-secondary weight-500">Total Pending Items</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy fa fa-check-circle text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Expected Payouts -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ $total_notified_items }}</div>
                        <div class="font-14 text-secondary weight-500">Notified Payments</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#ff5b5b">
                            <i class="icon-copy fa fa-bell text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Pending Consignments -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ $pending_consignments }}</div>
                        <div class="font-14 text-secondary weight-500">Pending Consignments</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#f39c12">
                            <i class="icon-copy fa fa-hourglass-half text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Selling Items -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ $selling_items }}</div>
                        <div class="font-14 text-secondary weight-500">Selling Items</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#09cc06">
                            <i class="icon-copy fa fa-shopping-cart text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
