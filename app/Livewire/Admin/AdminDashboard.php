<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\AdminDataAnalysisServices;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class AdminDashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url()]
    public $filterBestSellingProducts;

    #[Url()]
    public $selectedDay = 'today';

    public $monthlySalesAnalytics = [];


    protected $dataAnalysisService;

    // Inject the service into the mount method
    public function mount(AdminDataAnalysisServices $adminDataAnalysisServices)
    {
        $this->dataAnalysisService = $adminDataAnalysisServices;
        $this->selectedDay = 'today';
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
        $totalExpenses = $this->dataAnalysisService->getTotalExpenses();
        $totalExpectedRevenue = $this->dataAnalysisService->getTotalExpectedRevenue();
        $totalRevenue = $this->dataAnalysisService->getTotalRevenue();
        $totalCommissionFee = $this->dataAnalysisService->getTotalCommissionFee();
        $totalConsignors = $this->dataAnalysisService->getTotalConsignors();
        $totalPendingConsignmentRequest = $this->dataAnalysisService->getTotalPendingConsignmentRequest();
        $totalPendingPayments = $this->dataAnalysisService->getTotalPendingPayments();
        $totalInventoryItems = $this->dataAnalysisService->getInventoryTotalItems();
        $bestSellingProducts = $this->getPaginatedBestSellingProducts();
        $totals = $this->dataAnalysisService->totalSales($this->selectedDay);

        return view('livewire.admin.admin-dashboard', [
            'pageTitle' => 'Home',
            'totalExpenses' => $totalExpenses,
            'totalExpectedRevenue' => $totalExpectedRevenue,
            'totalRevenue' => $totalRevenue,
            'totalCommissionFee' => $totalCommissionFee,
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
