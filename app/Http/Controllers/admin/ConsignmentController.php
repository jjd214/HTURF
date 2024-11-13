<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class ConsignmentController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'pageTitle' => 'All consignments'
        ];
        return view('back.pages.admin.all-consign', $data);
    }

    public function createConsignment(Request $request)
    {
        $data = [
            'pageTitle' => 'Add consignment'
        ];
        return view('back.pages.admin.add-consign', $data);
    }

    public function consignmentRequest(Request $request)
    {
        $data = [
            'pageTitle' => 'All requests'
        ];
        return view('back.pages.admin.all-consign-request', $data);
    }

    public function showConsignmentDetails(Request $request, $id)
    {
        $decodeId = Crypt::decryptString($id);
        $data = [
            'pageTitle' => 'Details',
            'id' => $decodeId
        ];
        return view('back.pages.admin.consign-request-details', $data);
    }
}
