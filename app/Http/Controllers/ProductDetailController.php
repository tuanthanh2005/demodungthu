<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductDetailController
{
    public function show($id)
    {
        return view('shop.product-detail', ['id' => $id]);
    }
}

