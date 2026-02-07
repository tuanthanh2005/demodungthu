<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController
{
    public function index()
    {
        $products = [
            ['name' => 'Ao Thun Nam Basic Cotton', 'category' => 'Ao thun', 'price' => '245.000d', 'oldPrice' => '350.000d', 'badge' => '-30%', 'rating' => 4.5, 'img' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400'],
            ['name' => 'Vay Maxi Hoa Nhi Vintage', 'category' => 'Vay', 'price' => '450.000d', 'oldPrice' => '', 'badge' => 'new', 'rating' => 5.0, 'img' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=400'],
            ['name' => 'Giay The Thao Nam Cao Cap', 'category' => 'Giay', 'price' => '675.000d', 'oldPrice' => '900.000d', 'badge' => '-25%', 'rating' => 4.0, 'img' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400'],
            ['name' => 'Tui Xach Nu Da Cao Cap', 'category' => 'Tui xach', 'price' => '540.000d', 'oldPrice' => '900.000d', 'badge' => '-40%', 'rating' => 4.7, 'img' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400'],
            ['name' => 'Ao So Mi Nam Cong So', 'category' => 'Ao so mi', 'price' => '320.000d', 'oldPrice' => '', 'badge' => '', 'rating' => 4.2, 'img' => 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400'],
            ['name' => 'Quan Jean Nu Skinny', 'category' => 'Quan', 'price' => '380.000d', 'oldPrice' => '', 'badge' => 'new', 'rating' => 5.0, 'img' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=400'],
        ];

        return view('pages.home', compact('products'));
    }
}

