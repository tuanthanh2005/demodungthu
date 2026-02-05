<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AIChatController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Services\GroqAI;

Route::get('/', function () {
    $products = \App\Models\Product::with('category')->latest()->take(20)->get();
    $categories = \App\Models\Category::all();
    return view('home', compact('products', 'categories'));
});

// Mobile-first version route
Route::get('/mobile', function () {
    $products = \App\Models\Product::with('category')->latest()->take(20)->get();
    $categories = \App\Models\Category::all();
    return view('home-mobile', compact('products', 'categories'));
});

Route::get('/admin', function () {
    return view('admin');
})->middleware('auth', 'admin');

// ========== AUTHENTICATION ROUTES ==========
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/checkout', function () {
    return view('checkout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Products listing page (separate from product detail)
Route::get('/products', function () {
    return view('products');
})->name('products');

Route::get('/products/{slug}', [ProductController::class, 'detailPage']);

// Orders pages
Route::middleware('auth')->group(function () {
    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');
});

// ========== PRODUCT API ROUTES ==========
Route::prefix('api/products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/categories', [ProductController::class, 'getCategories']);
    Route::get('/slug/{slug}', [ProductController::class, 'showBySlug']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
    
    // Variant routes
    Route::get('/{productId}/variants', [ProductVariantController::class, 'index']);
    Route::post('/variants', [ProductVariantController::class, 'store']);
    Route::post('/variants/bulk', [ProductVariantController::class, 'bulkStore']);
    Route::put('/variants/{id}', [ProductVariantController::class, 'update']);
    Route::delete('/variants/{id}', [ProductVariantController::class, 'destroy']);
});

// ========== IMAGE UPLOAD ROUTE ==========
Route::post('/api/upload-image', [ProductController::class, 'uploadImage']);

// ========== CATEGORY API ROUTES ==========
Route::prefix('api/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});

// ========== ORDER API ROUTES ==========
Route::prefix('api/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/my', [OrderController::class, 'myOrders'])->middleware('auth');
    Route::get('/{id}', [OrderController::class, 'show']);
    Route::post('/', [OrderController::class, 'store']);
});

// ========== SETTINGS API ROUTES ==========
Route::prefix('api/settings')->group(function () {
    Route::get('/footer', [SettingsController::class, 'getFooterSettings']);
    Route::post('/footer', [SettingsController::class, 'saveFooterSettings']);
    Route::get('/website', [SettingsController::class, 'getWebsiteSettings']);
    Route::post('/website', [SettingsController::class, 'saveWebsiteSettings'])->middleware('auth', 'admin');
});

// ========== AI API ROUTES ==========

// AI Chatbot
Route::post('/api/ai/chat', [AIChatController::class, 'chat']);

// AI Search Suggestions
Route::post('/api/ai/search-suggestions', function (Request $request) {
    $groq = new GroqAI();
    
    $query = $request->input('query');
    
    $response = $groq->productSearch($query);
    
    return response()->json($response);
});

// AI Product Recommendations
Route::post('/api/ai/recommendations', function (Request $request) {
    $groq = new GroqAI();
    
    $preferences = $request->input('preferences');
    
    $response = $groq->productRecommendation($preferences);
    
    return response()->json($response);
});
