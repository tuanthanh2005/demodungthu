<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get product details by ID
     */
    public function show($id)
    {
        try {
            $product = Product::with('category')->findOrFail($id);
            
            return response()->json([
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'regular_price' => $product->regular_price,
                'sale_price' => $product->sale_price,
                'image' => $product->image,
                'images' => $product->images ?? [],
                'sizes' => $product->sizes ?? [],
                'colors' => $product->colors ?? [],
                'size_prices' => $product->size_prices ?? [],
                'color_prices' => $product->color_prices ?? [],
                'quantity' => $product->quantity,
                'in_stock' => $product->in_stock,
                'category' => $product->category ? $product->category->name : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }
    }
}
