@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
<style>
    .icon-circle {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 20px;
    }
</style>
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Dashboard</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Dashboard
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-3 col-sm-12 text-right">

        </div>
    </div>
</div>

@livewire('admin.admin-dashboard')

<div class="card-box pd-20 mb-20">
    <div class="d-flex justify-content-between align-items-center mb-30">
        <h2 class="h4 mb-0">Monthly Sales Analytics</h2>
                <form method="GET" action="{{ route('admin.home') }}">
                    <label for="year">Select Year:</label>
                    <select id="year" name="year" class="custom-select form-control" onchange="this.form.submit()">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </form>
    </div>
    <canvas id="salesAnalyticsChart"></canvas>
</div>

<script>
    // Data from the controller
    const salesData = @json($monthlySalesAnalytics);

    // Prepare data for Chart.js
    const labels = salesData.map(data => new Date(0, data.month - 1).toLocaleString('default', { month: 'long' }));
    const sales = salesData.map(data => data.total_sales);

    // Initialize the chart
    const ctx = document.getElementById('salesAnalyticsChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales (₱)',
                data: sales,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Update chart when new data is fetched
    document.addEventListener('DOMContentLoaded', () => {
        salesChart.data.labels = labels;
        salesChart.data.datasets[0].data = sales;
        salesChart.update();
    });
</script>
@endsection
