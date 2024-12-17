<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Consignment;
use Illuminate\Support\Facades\Storage;
use App\Models\ConsignmentRequest;
use App\Models\Inventory;
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

    public function showConsignmentDetails($id)
    {
        $product = Inventory::leftJoin('consignments', 'inventories.consignment_id', '=', 'consignments.id')
            ->select('inventories.*', 'consignments.*')
            ->where('inventories.consignment_id', $id)
            ->first();
        return view('back.pages.user.consignment-details', compact('product'));
    }

    public function destroyConsignmentRequest($id)
    {
        // Retrieve the record for deletion
        $product = ConsignmentRequest::where('id', $id)
            ->where('consignor_id', auth('user')->id())
            ->first();

        // Check if the product exists
        if (!$product) {
            return redirect()->route('back.pages.user.all-consignments')
                ->with('error', 'Consignment request not found or unauthorized.');
        }

        $file = $product->image;
        $path = 'public/images/requests/';

        $pictures = json_decode($product->image, true); // true ensures it's an array

        // Delete each image if it exists
        if (is_array($pictures)) {
            foreach ($pictures as $file) {
                if ($file !== null && Storage::exists($path . $file)) {
                    Storage::delete($path . $file);
                }
            }
        }

        // Perform deletion
        $product->delete();

        // Redirect with success message
        return redirect()->route('consignor.consignment.all-consignments')
            ->with('success', 'Consignment request successfully deleted.');
    }
}
