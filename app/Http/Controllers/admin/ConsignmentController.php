<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Consignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\ConsignmentRequest;
use App\Models\Inventory;
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
        $product = ConsignmentRequest::where('id', $id)->first();

        $consignment = Consignment::create([
            'consignor_id' => $product->consignor_id,
            'commission_percentage' => $product->consignor_commission,
            'start_date' => now(),
            'expiry_date' => $product->pullout_date,
        ]);

        Inventory::create([
            'consignment_id' => $consignment->id,
            'name' => $product->name,
            'brand' => $product->brand,
            'sku' => $product->sku,
            'size' => $product->size,
            'color' => $product->colorway,
            'sex' => $product->sex,
            'qty' => $product->quantity,
            'description' => $product->description,
            'purchase_price' => $product->purchase_price,
            'selling_price' => $product->selling_price,
            'picture' => null,
            'visibility' => 'public',
            'status' => 1,
        ]);

        $product->delete();

        session()->flash('success', 'Consignment request approved. 👌🏻');
        return redirect()->route('admin.consignment.all-request');
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
