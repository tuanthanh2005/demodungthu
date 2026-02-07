<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShippingPolicyController;
use App\Http\Controllers\ReturnPolicyController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\FlashellController;
use Illuminate\Support\Facades\Artisan;

// Route trang chủ - hiển thị giao diện e-commerce
Route::get('/', [HomeController::class, 'index']);
Route::get('/shop', [ProductController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/contact', [ContactController::class, 'index']);
Route::get('/wishlist', [WishlistController::class, 'index']);
Route::get('/cart', [CartController::class, 'index']);
Route::get('/checkout', [CheckoutController::class, 'index']);
Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/shipping', [ShippingPolicyController::class, 'index']);
Route::get('/returns', [ReturnPolicyController::class, 'index']);
Route::get('/faq', [FaqController::class, 'index']);
Route::get('/product/{id}', [ProductDetailController::class, 'show']);
Route::get('/flashell', [FlashellController::class, 'index']);

Route::get('/admin', function () {
    return view('admin');
});

Route::post('/admin/clear-cache', function () {
    abort_unless(app()->environment('local'), 403);

    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');

    return back()->with('status', 'Đã xóa cache thành công.');
});
