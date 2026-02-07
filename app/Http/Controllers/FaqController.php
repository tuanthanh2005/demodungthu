<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController
{
    public function index()
    {
        return view('pages.faq');
    }
}

