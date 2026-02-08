<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController
{
    public function index()
    {
        $categories = \App\Models\Category::withCount('products')->get();
        return view('shop.categories', compact('categories'));
    }
}

