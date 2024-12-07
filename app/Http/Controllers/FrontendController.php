<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //
    public function homePage(Request $request)
    {
        $data = [
            'pageTitle' => 'Hype archive'
        ];
        return view('front.pages.home', $data);
    }
}
