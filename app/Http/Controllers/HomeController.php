<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController
{
    public function index()
    {
        // Get products from database, ordered by latest
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('pages.home', compact('products'));
    }
}


