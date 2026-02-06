<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController
{
    public function index()
    {
        return view('checkout');
    }
}
