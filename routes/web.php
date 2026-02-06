<?php

use Illuminate\Support\Facades\Route;

// Route trang chủ - hiển thị giao diện e-commerce
Route::get('/', function () {
    return view('home');
});
