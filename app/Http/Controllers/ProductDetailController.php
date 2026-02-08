<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductDetailController
{
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('shop.product-detail', compact('product'));
    }
}

