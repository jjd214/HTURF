<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\AdminDataAnalysisServices;


class AdminDashboard extends Component
{
    protected $dataAnalysisService;

    public function mount(AdminDataAnalysisServices $adminDataAnalysisServices)
    {
        $this->dataAnalysisService = $adminDataAnalysisServices;
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
        $bestSellingProducts = $this->dataAnalysisService->getBestSellingProducts();

        $data = [
            'pageTitle' => 'Home',
            'totalExpenses' => $totalExpenses,
            'totalExpectedRevenue' => $totalExpectedRevenue,
            'totalRevenue' => $totalRevenue,
            'totalCommissionFee' => $totalCommissionFee,
            'totalConsignors' => $totalConsignors,
            'totalPendingConsignmentRequest' => $totalPendingConsignmentRequest,
            'totalPendingPayments' => $totalPendingPayments,
            'totalInventoryItems' => $totalInventoryItems,
            'bestSellingProducts' => $bestSellingProducts
        ];

        return view('livewire.admin.admin-dashboard', $data);
    }
}
