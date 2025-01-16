<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\AdminDataAnalysisServices;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url()]
    public $filterBestSellingProducts;

    #[Url()]
    public $selectedDay = 'today';

    public $monthlySalesAnalytics = [];

    public $selectedMonth;
    public $totalExpenses;
    public $totalExpectedRevenue;
    public $totalRevenue;
    public $totalCommissionFee;
    public $months;

    protected $dataAnalysisService;

    // Inject the service into the mount method
    public function mount(AdminDataAnalysisServices $adminDataAnalysisServices)
    {
        $this->dataAnalysisService = $adminDataAnalysisServices;
        $this->selectedMonth = now()->format('F Y'); // Default to the current month
        $this->months = $this->getLastTwelveMonths();
        $this->selectedDay = 'today';
    }

    public function updatedSelectedMonth()
    {
        $this->updateData();
    }

    private function updateData()
    {
        [$month, $year] = explode(' ', $this->selectedMonth);
        $this->totalExpenses = $this->dataAnalysisService->getTotalExpensesByMonth($month, $year);
        $this->totalExpectedRevenue = $this->dataAnalysisService->getTotalExpectedRevenueByMonth($month, $year);
        $this->totalRevenue = $this->dataAnalysisService->getTotalRevenueByMonth($month, $year);
        $this->totalCommissionFee = $this->dataAnalysisService->getTotalCommissionFeeByMonth($month, $year);
    }

    private function getLastTwelveMonths()
    {
        $months = [];
        $currentDate = Carbon::now();
        for ($i = 0; $i < 12; $i++) {
            $months[] = $currentDate->format('F Y');
            $currentDate->subMonth();
        }
        return $months;
    }

    // Rehydrate the service on every request
    public function hydrate()
    {
        $this->dataAnalysisService = app(AdminDataAnalysisServices::class);
    }

    public function getLastFiveYearsDates()
    {
        $dates = [];
        $currentDate = now();

        for ($i = 0; $i < 60; $i++) {
            $dates[] = $currentDate->format('F Y');
            $currentDate->subMonth();
        }
        return $dates;
    }

    public function render()
    {
        // $totalExpenses = $this->dataAnalysisService->getTotalExpenses();
        // $totalExpectedRevenue = $this->dataAnalysisService->getTotalExpectedRevenue();
        // $totalRevenue = $this->dataAnalysisService->getTotalRevenue();
        // $totalCommissionFee = $this->dataAnalysisService->getTotalCommissionFee();
        $totalConsignors = $this->dataAnalysisService->getTotalConsignors();
        $totalPendingConsignmentRequest = $this->dataAnalysisService->getTotalPendingConsignmentRequest();
        $totalPendingPayments = $this->dataAnalysisService->getTotalPendingPayments();
        $totalInventoryItems = $this->dataAnalysisService->getInventoryTotalItems();
        $bestSellingProducts = $this->getPaginatedBestSellingProducts();
        $totals = $this->dataAnalysisService->totalSales($this->selectedDay);

        return view('livewire.admin.admin-dashboard', [
            'pageTitle' => 'Home',
            // 'totalExpenses' => $totalExpenses,
            // 'totalExpectedRevenue' => $totalExpectedRevenue,
            // 'totalRevenue' => $totalRevenue,
            // 'totalCommissionFee' => $totalCommissionFee,
            'totalConsignors' => $totalConsignors,
            'totalPendingConsignmentRequest' => $totalPendingConsignmentRequest,
            'totalPendingPayments' => $totalPendingPayments,
            'totalInventoryItems' => $totalInventoryItems,
            'bestSellingProducts' => $bestSellingProducts,
            'lastFiveYearsDates' => $this->getLastFiveYearsDates(),
            'totalSales' => $totals['totalSales'],
            'totalItemsSold' => $totals['totalItemsSold'],
        ]);
    }

    public function getPaginatedBestSellingProducts()
    {
        $query = $this->dataAnalysisService->getBestSellingProducts($this->filterBestSellingProducts);

        return $query->paginate(5);
    }
}