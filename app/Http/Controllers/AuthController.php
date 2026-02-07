<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function logout()
    {
        return redirect('/');
    }
}



