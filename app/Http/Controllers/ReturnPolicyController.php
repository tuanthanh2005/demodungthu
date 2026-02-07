<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReturnPolicyController
{
    public function index()
    {
        return view('pages.returns');
    }
}

