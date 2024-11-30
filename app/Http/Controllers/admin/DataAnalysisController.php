<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DataAnalysisController extends Controller
{
    public function index(Request $request)
    {
        $monthlySalesAnalytics = DB::table('transactions')
            ->selectRaw('YEAR(created_at) as year, SUM(total_amount) as total_sales')
            ->whereMonth('created_at', now()->month)
            ->groupByRaw('YEAR(created_at)')
            ->orderBy('year', 'desc')
            ->limit(5)
            ->get()
            ->map(fn($row) => ['year' => $row->year, 'total_sales' => $row->total_sales])
            ->toArray();

        return view('back.pages.admin.home', compact('monthlySalesAnalytics'));
    }
}
