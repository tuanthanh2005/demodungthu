<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController
{
    public function index()
    {
        return view('contact');
    }
}
