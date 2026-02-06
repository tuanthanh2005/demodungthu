<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController
{
    public function index()
    {
        return view('categories');
    }
}
