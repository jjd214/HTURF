<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;

class DataAnalysisController extends Controller
{
    public function index(Request $request)
    {
        $totalExpectedRevenue = $this->getTotalExpectedRevenue();

        return view(
            'back.pages.admin.home',
            [
                'totalExpectedRevenue' => $totalExpectedRevenue
            ]
        );
    }

    public function getTotalExpectedRevenue()
    {
        $totalExpenses = Inventory::where('consignment_id', null)->select('purchase_price');
        return $totalExpenses;
    }
}
