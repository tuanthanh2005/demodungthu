<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController
{
    public function index()
    {
        return view('cart');
    }
}
