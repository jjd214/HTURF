<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Consignment;
use App\Models\ConsignmentRequest;
use Illuminate\Http\Request;

class ConsignmentController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'pageTitle' => 'My Inventory'
        ];
        return view('back.pages.user.all-consignments', $data);
    }

    public function createConsignment(Request $request)
    {
        $data = [
            'pageTitle' => 'Consignment submission'
        ];
        return view('back.pages.user.add-consignment', $data);
    }

    public function showConsignmentStatusDetails($id)
    {
        $product = ConsignmentRequest::where('id', $id)->first();
        return view('back.pages.user.consignment-status-details', compact('product'));
    }
}
