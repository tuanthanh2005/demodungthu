<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('shop.cart', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        try {
            $id = $request->input('id');
            if (!$id) {
                return response()->json(['error' => 'Product ID is missing'], 400);
            }

            $product = Product::findOrFail($id);
            
            $cart = session()->get('cart', []);
            
            $size = $request->input('size', 'Standard');
            $color = $request->input('color', 'Standard');
            $quantity = (int) $request->input('quantity', 1);
            
            // Get price for this specific variant
            $variantPrice = $product->getPriceForVariant($size, $color);
            
            // Create a unique key for the item based on ID, size, and color
            $cartKey = $id . '_' . $size . '_' . $color;

            if(isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $quantity;
            } else {
                $cart[$cartKey] = [
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "quantity" => $quantity,
                    "price" => $variantPrice, // Use variant price instead of base price
                    "image" => $product->image ?? 'https://via.placeholder.com/400',
                    "size" => $size,
                    "color" => $color
                ];
            }

            session()->put('cart', $cart);
            
            // Check if request expects JSON (from fetch API)
            if($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => 'Đã thêm vào giỏ hàng!', 
                    'cart_count' => count($cart)
                ]);
            }

            return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
            
        } catch (\Exception $e) {
            \Log::error('Cart Add Error: ' . $e->getMessage());
            if($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Lỗi: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            
            $subtotal = $cart[$request->id]["quantity"] * $cart[$request->id]["price"];
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'msg' => 'Cart updated successfully', 
                'subtotal' => number_format($subtotal, 0, ',', '.') . 'đ',
                'total' => number_format($total, 0, ',', '.') . 'đ'
            ]);
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'msg' => 'Product removed successfully',
                'total' => number_format($total, 0, ',', '.') . 'đ',
                'cart_count' => count($cart)
            ]);
        }
    }
}
