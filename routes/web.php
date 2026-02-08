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
// Admin Product Management
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;

// Route trang chủ
Route::get('/', [HomeController::class, 'index']);
Route::get('/shop', [ProductController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/contact', [ContactController::class, 'index']);
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::delete('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost']);
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/shipping', [ShippingPolicyController::class, 'index']);
Route::get('/returns', [ReturnPolicyController::class, 'index']);
Route::get('/faq', [FaqController::class, 'index']);
Route::get('/product/{id}', [ProductDetailController::class, 'show']);
Route::get('/flashell', [FlashellController::class, 'index']);

// API Routes
Route::get('/api/product/{id}', [App\Http\Controllers\Api\ProductController::class, 'show']);

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('dashboard');

    Route::post('/clear-cache', function () {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            return back()->with('status', 'Đã xóa cache thành công.');
    });
    
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::post('products/{product}/quantity', [AdminProductController::class, 'updateQuantity'])
        ->name('products.quantity');
});
