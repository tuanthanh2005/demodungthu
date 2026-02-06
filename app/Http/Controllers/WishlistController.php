<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController
{
    public function index()
    {
        return view('wishlist');
    }
}
