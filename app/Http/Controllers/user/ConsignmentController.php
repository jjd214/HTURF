<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsignmentController extends Controller
{
    public function createConsignment(Request $request)
    {
        $data = [
            'pageTitle' => 'Consignment submission'
        ];
        return view('back.pages.user.add-consignment', $data);
    }
}
