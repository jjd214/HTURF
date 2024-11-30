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

<div class="row">
    <div class="col-md-8">
        <div class="card-box pd-20 mb-20">
            <div class="d-flex justify-content-between align-items-center mb-30">
                <h2 class="h4 mb-0">Monthly expenses Analytics</h2>
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
            <canvas id="expensesAnalyticsChart"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-box pd-20 mb-20" style="height: 480px;">
            <div class="d-flex justify-content-between align-items-center mb-30">
                <h2 class="h4 mb-0">Revenue Breakdown for {{ $selectedYear }}</h2>
                <!-- Select Year -->
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
            <canvas id="revenuePieChart"></canvas>
        </div>
    </div>

</div>

<script>
    // Data from the controller
    const salesData = @json($monthlySalesAnalytics);
    const expensesData = @json($monthlyExpensesAnalytics);

    // Prepare data for Sales Chart.js
    const labels = salesData.map(data => new Date(0, data.month - 1).toLocaleString('default', { month: 'long' }));
    const sales = salesData.map(data => data.total_sales);

    // Prepare data for Expenses Chart.js
    const expenses = expensesData.map(data => data.total_expenses);

    // Initialize the Sales chart
    const salesCtx = document.getElementById('salesAnalyticsChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
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

    // Initialize the Expenses chart
    const expensesCtx = document.getElementById('expensesAnalyticsChart').getContext('2d');
    const expensesChart = new Chart(expensesCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Expenses (₱)',
                data: expenses,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
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

    const totalRevenue = Math.round(@json($totalRevenue));
    const expectedRevenue = Math.round(@json($expectedRevenue));

    // Initialize the Pie Chart for Revenue Breakdown
    const ctx = document.getElementById('revenuePieChart').getContext('2d');
    const revenuePieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Total Revenue', 'Expected Revenue'],
            datasets: [{
                label: 'Revenue Breakdown',
                data: [totalRevenue, expectedRevenue],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 159, 64, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ₱' + tooltipItem.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Update charts when new data is fetched
    document.addEventListener('DOMContentLoaded', () => {
        salesChart.data.labels = labels;
        salesChart.data.datasets[0].data = sales;
        salesChart.update();

        expensesChart.data.labels = labels;
        expensesChart.data.datasets[0].data = expenses;
        expensesChart.update();
    });
</script>
@endsection
