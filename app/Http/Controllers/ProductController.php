<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController
{
    public function index()
    {
        return view('shop');
    }
}
