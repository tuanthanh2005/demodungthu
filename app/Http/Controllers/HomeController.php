<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController
{
    public function index()
    {
        // Get products from database, ordered by latest
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Get categories
        $categories = Category::withCount('products')->orderBy('products_count', 'desc')->limit(6)->get();

        return view('pages.home', compact('products', 'categories'));
    }
}


