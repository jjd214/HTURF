<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\ConsignmentRequest;
use App\Models\User;


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

        $consignment_request = ConsignmentRequest::where('id', $decodeId)->first();
        $consignor_details = User::where('id', $consignment_request->consignor_id)->first();
        $data = [
            'pageTitle' => 'Details',
            'consignmentRequestDetails' => $consignment_request,
            'consignorDetails' => $consignor_details
        ];
        return view('back.pages.admin.consign-request-details', $data);
    }

    public function acceptConsignmentRequest(Request $request, $id)
    {
        ConsignmentRequest::where('id', $id)->update([
            'status' => 'Approved'
        ]);
        session()->flash('success', 'Consignment request approved. 👌🏻');
        return redirect()->back();
    }

    public function rejectConsignmentRequest(Request $request, $id)
    {
        ConsignmentRequest::where('id', $id)->update([
            'status' => 'Rejected'
        ]);
        session()->flash('info', 'Consignment request rejected. 🙅');
        return redirect()->back();
    }
}
