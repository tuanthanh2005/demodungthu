<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShippingPolicyController
{
    public function index()
    {
        return view('pages.shipping');
    }
}

