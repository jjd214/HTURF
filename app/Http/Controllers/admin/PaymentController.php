<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\Consignment;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        return view('back.pages.admin.all-payments');
    }

    public function sendPaymentDetails(Request $request)
    {
        $item_details = Payment::leftJoin('inventories', 'payments.inventory_id', '=', 'inventories.id')
            ->select(
                'inventories.consignment_id',
                'inventories.name',
                'inventories.brand',
                'inventories.sku',
                'inventories.color',
                'inventories.selling_price',
                'inventories.picture',
                'payments.*'
            )
            ->where('payments.id', $request->payment_id)
            ->first();

        if (!$item_details) {
            return response()->json([
                'status' => 0,
                'msg' => 'Payment details not found.',
                'type' => 'error',
            ]);
        }

        $consignment_details = Consignment::find($item_details->consignment_id);
        $consignor_details = $consignment_details ? User::find($consignment_details->consignor_id) : null;

        if (!$consignment_details || !$consignor_details) {
            return response()->json([
                'status' => 0,
                'msg' => 'Consignment or consignor details not found.',
                'type' => 'error',
            ]);
        }

        // Assign data to $data array for the email template
        $data = [
            'item_name' => $item_details->name,
            'item_brand' => $item_details->brand,
            'item_sku' => $item_details->sku,
            'item_color' => $item_details->color,
            'item_price' => $item_details->selling_price,
            'item_qty' => $item_details->quantity,
            'consignor_name' => $consignor_details->name,
            'consignor_email' => $consignor_details->email,
            'consignment_commission_percentage' => $consignment_details->commission_percentage,
            'consignment_start_date' => $consignment_details->start_date,
            'consignment_expiry_date' => $consignment_details->expiry_date,
            'purchase_date' => $item_details->created_at,
            'payment_code' => $item_details->payment_code,
            'sub_total' => $item_details->selling_price * $item_details->quantity,
            'total_tax' => $item_details->tax,
            'total' => $item_details->selling_price * $item_details->quantity - $item_details->tax,
            'claim_date' => $request->claim_date,
            'claim_time' => $request->claim_time
        ];

        $mail_body = view('email-templates.user-payment-email-template', $data);

        $mailConfig = [
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $consignor_details->email,
            'mail_recipient_name' => $consignor_details->name,
            'mail_subject' => 'Payment Details',
            'mail_body' => $mail_body,
        ];

        if (sendEmail($mailConfig)) {
            $item_details->status = "Notified";
            $item_details->date_of_payment = $request->claim_date . " " . $request->claim_time;
            $item_details->save();
            return redirect()->back()->with('success', 'Email sent successfully!');
        } else {
            return redirect()->back()->with('fail', 'Something went wrong.');
        }
    }

    public function showPaymentDetails(Request $request, $payment_code)
    {
        $item_details = Payment::leftjoin('inventories', 'payments.inventory_id', '=', 'inventories.id')
            ->select('inventories.consignment_id', 'inventories.name', 'inventories.brand', 'inventories.sku', 'inventories.color', 'inventories.selling_price', 'inventories.picture', 'payments.*')
            ->where('payments.payment_code', $payment_code)
            ->first();

        $consignment_details = Consignment::where('id', $item_details['consignment_id'])->first();

        $consignor_details = User::where('id', $consignment_details['consignor_id'])->first();

        $payment_details = Payment::where('payment_code', $payment_code)->first();

        return view('back.pages.admin.payment-details', [
            'itemDetails' => $item_details,
            'consignmentDetails' => $consignment_details,
            'consignorDetails' => $consignor_details,
            'paymentDetails' => $payment_details
        ]);
    }

    public function completePaymentHandler(Request $request)
    {
        $payment_details = Payment::find($request->payment_id);

        if (!$payment_details) {
            return redirect()->back()->with('fail', 'Payment not found.');
        }

        // Generate a unique reference number if not already present
        if (!$payment_details->reference_no) {
            do {
                $reference_number = mt_rand(1000000000, 9999999999);
            } while (Payment::where('reference_no', $reference_number)->exists());
            $payment_details->reference_no = $reference_number;
        }

        $inventory_details = Inventory::find($payment_details->inventory_id);
        $consignment_details = Consignment::find($inventory_details->consignment_id ?? null);
        $consignor_details = User::find($consignment_details->consignor_id ?? null);

        if (!$consignor_details) {
            return redirect()->back()->with('fail', 'Consignor details not found.');
        }

        $data = [
            'consignor_name' => $consignment_details->name ?? $consignment_details->username,
            'payment_id' => $payment_details->payment_code,
            'payment_amount' => $payment_details->total,
            'payment_date' => now()->format('F j, Y, g:i A'),
        ];

        $mail_body = view('email-templates.user-complete-payment-email-template', $data)->render();

        $mailConfig = [
            'mail_from_email' => env('MAIL_FROM_ADDRESS', 'default@example.com'),
            'mail_from_name' => env('MAIL_FROM_NAME', 'Your Company'),
            'mail_recipient_email' => $consignor_details->email,
            'mail_recipient_name' => $consignor_details->name,
            'mail_subject' => 'Payment Completed',
            'mail_body' => $mail_body,
        ];

        if (sendEmail($mailConfig)) {
            $payment_details->status = "Completed";
            $payment_details->save();
            return redirect()->back()->with('success', 'Payment completed 👍');
        } else {
            return redirect()->back()->with('fail', 'Failed to send payment confirmation email.');
        }
    }
}
