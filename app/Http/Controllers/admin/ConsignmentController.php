<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Consignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\ConsignmentRequest;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
        // Fetch the consignment request
        $product = ConsignmentRequest::where('id', $id)->first();

        if (!$product) {
            Log::warning(
                "Attempted to accept a non-existent consignment request",
                [
                    'time_stamp' => now()->format('F j, Y g:i A'),
                    'request_id' => $id
                ]
            );
            session()->flash('error', 'Consignment request not found.');
            return redirect()->route('admin.consignment.all-request');
        }

        // Create a new consignment
        $consignment = Consignment::create([
            'consignor_id' => $product->consignor_id,
            'commission_percentage' => $product->consignor_commission,
            'start_date' => now(),
            'expiry_date' => $product->pullout_date,
        ]);

        // Create a new inventory
        $inventory = Inventory::create([
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

        // Log the acceptance of the consignment request
        Log::info(
            "Consignment request approved successfully",
            [
                'time_stamp' => now()->format('F j, Y g:i A'),
                'Request Details' => [
                    'request_id' => $product->id,
                    'consignor_id' => $product->consignor_id,
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'sku' => $product->sku,
                    'size' => $product->size,
                    'color' => $product->colorway,
                    'sex' => $product->sex,
                    'quantity' => $product->quantity,
                    'purchase_price' => $product->purchase_price,
                    'selling_price' => $product->selling_price,
                    'pullout_date' => $product->pullout_date,
                ],
                'Consignment Details' => [
                    'consignment_id' => $consignment->id,
                    'commission_percentage' => $consignment->commission_percentage,
                    'start_date' => $consignment->start_date,
                    'expiry_date' => $consignment->expiry_date,
                ],
                'Inventory Details' => [
                    'inventory_id' => $inventory->id,
                    'visibility' => $inventory->visibility,
                    'status' => $inventory->status,
                ]
            ]
        );

        // Delete the consignment request
        $product->delete();

        // Flash success message and redirect
        session()->flash('success', 'Consignment request approved. 👌🏻');
        return redirect()->route('admin.consignment.all-request');
    }


    // public function acceptConsignmentRequest(Request $request, $id)
    // {
    //     $product = ConsignmentRequest::where('id', $id)->first();

    //     $consignment = Consignment::create([
    //         'consignor_id' => $product->consignor_id,
    //         'commission_percentage' => $product->consignor_commission,
    //         'start_date' => now(),
    //         'expiry_date' => $product->pullout_date,
    //     ]);

    //     Inventory::create([
    //         'consignment_id' => $consignment->id,
    //         'name' => $product->name,
    //         'brand' => $product->brand,
    //         'sku' => $product->sku,
    //         'size' => $product->size,
    //         'color' => $product->colorway,
    //         'sex' => $product->sex,
    //         'qty' => $product->quantity,
    //         'description' => $product->description,
    //         'purchase_price' => $product->purchase_price,
    //         'selling_price' => $product->selling_price,
    //         'picture' => null,
    //         'visibility' => 'public',
    //         'status' => 1,
    //     ]);

    //     $product->delete();

    //     session()->flash('success', 'Consignment request approved. 👌🏻');
    //     return redirect()->route('admin.consignment.all-request');
    // }

    public function rejectConsignmentRequest(Request $request, $id)
    {
        // Find the consignment request
        $consignmentRequest = ConsignmentRequest::find($id);

        if (!$consignmentRequest) {
            // Log a warning if the request doesn't exist
            Log::warning(
                "Attempted to reject a non-existent consignment request",
                [
                    'time_stamp' => now()->format('F j, Y g:i A'),
                    'request_id' => $id
                ]
            );

            session()->flash('error', 'Consignment request not found.');
            return redirect()->back();
        }

        // Update the status to 'Rejected'
        $consignmentRequest->update([
            'status' => 'Rejected'
        ]);

        // Log the rejection
        Log::info(
            "Consignment request rejected successfully",
            [
                'time_stamp' => now()->format('F j, Y g:i A'),
                'Request Details' => [
                    'request_id' => $consignmentRequest->id,
                    'consignor_id' => $consignmentRequest->consignor_id,
                    'name' => $consignmentRequest->name,
                    'brand' => $consignmentRequest->brand,
                    'sku' => $consignmentRequest->sku,
                    'size' => $consignmentRequest->size,
                    'color' => $consignmentRequest->colorway,
                    'sex' => $consignmentRequest->sex,
                    'quantity' => $consignmentRequest->quantity,
                    'purchase_price' => $consignmentRequest->purchase_price,
                    'selling_price' => $consignmentRequest->selling_price,
                    'pullout_date' => $consignmentRequest->pullout_date,
                    'status' => 'Rejected',
                ]
            ]
        );

        // Flash an info message
        session()->flash('info', 'Consignment request rejected. 🙅');

        // Redirect back
        return redirect()->back();
    }

    // public function rejectConsignmentRequest(Request $request, $id)
    // {
    //     ConsignmentRequest::where('id', $id)->update([
    //         'status' => 'Rejected'
    //     ]);
    //     session()->flash('info', 'Consignment request rejected. 🙅');
    //     return redirect()->back();
    // }
}
