<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlashellController
{
    public function index()
    {
        $products = \App\Models\Product::inRandomOrder()->limit(12)->get();
        return view('shop.flashell', compact('products'));
    }
}

