<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function forgotPassword()
    {
        return view('forgot-password');
    }

    public function logout()
    {
        return redirect('/');
    }
}
