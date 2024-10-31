<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('back.pages.admin.all-payments');
    }

    public function showPaymentDetails(Request $request, $payment_code)
    {
        
        return view('back.pages.admin.payment-details');
    }
}
