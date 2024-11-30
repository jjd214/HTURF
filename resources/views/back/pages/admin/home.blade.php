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
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-3 col-sm-12 text-right"></div>
    </div>
</div>

@livewire('admin.admin-dashboard')

<div class="card-box pd-20 mb-20">
    <div class="d-flex justify-content-between align-items-center mb-30">
        <h2 class="h4 mb-0">Monthly Sales Analytics</h2>
        <form method="GET" action="{{ route('admin.home') }}">
            <label for="sales_year">Select Year:</label>
            <select id="sales_year" name="sales_year" class="custom-select form-control" onchange="this.form.submit()">
                @for ($year = now()->year; $year >= 2000; $year--)
                    <option value="{{ $year }}" {{ $year == $selectedSalesYear ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endfor
            </select>
        </form>
    </div>
    <canvas id="salesAnalyticsChart"></canvas>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card-box pd-20 mb-20">
            <div class="d-flex justify-content-between align-items-center mb-30">
                <h2 class="h4 mb-0">Monthly Expenses Analytics</h2>
                <form method="GET" action="{{ route('admin.home') }}">
                    <label for="expenses_year">Select Year:</label>
                    <select id="expenses_year" name="expenses_year" class="custom-select form-control" onchange="this.form.submit()">
                        @for ($year = now()->year; $year >= 2000; $year--)
                            <option value="{{ $year }}" {{ $year == $selectedExpensesYear ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </form>
            </div>
            <canvas id="expensesAnalyticsChart"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-box pd-20 mb-20" style="height: 479px;">
            <div class="d-flex justify-content-between align-items-center mb-30">
                <h2 class="h4 mb-0">Revenue breakdown</h2>
                <form method="GET" action="{{ route('admin.home') }}">
                    <label for="revenue_year">Select Year:</label>
                    <select id="revenue_year" name="revenue_year" class="custom-select form-control" onchange="this.form.submit()">
                        @for ($year = now()->year; $year >= 2000; $year--)
                            <option value="{{ $year }}" {{ $year == $selectedRevenueYear ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </form>
            </div>
            <canvas id="revenuePieChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('salesAnalyticsChart').getContext('2d');
        const salesData = @json(array_values($salesData));
        const labels = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sales (₱)',
                    data: salesData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Monthly Sales Analytics for {{ $selectedSalesYear }}'
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
    });

    document.addEventListener('DOMContentLoaded', () => {
        const ctxExpenses = document.getElementById('expensesAnalyticsChart').getContext('2d');
        const expensesData = @json(array_values($expensesData));
        const labels = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        new Chart(ctxExpenses, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Expenses (₱)',
                    data: expensesData,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Monthly Expenses Analytics for {{ $selectedExpensesYear }}'
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
    });

    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('revenuePieChart').getContext('2d');
        const revenueData = {
            labels: ['Total Revenue', 'Expected Revenue'],
            datasets: [{
                data: [{{ $totalRevenue }}, {{ $expectedRevenue }}],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 159, 64, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)'],
                borderWidth: 1,
            }]
        };

        new Chart(ctx, {
            type: 'pie',
            data: revenueData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Revenue Breakdown for {{ $selectedRevenueYear }}'
                    }
                }
            }
        });
    });
</script>
@endsection
