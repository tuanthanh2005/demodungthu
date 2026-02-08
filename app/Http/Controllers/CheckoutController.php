<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Recalculate cart totals to ensure correct prices
        $cartItems = [];
        $subtotal = 0;
        
        foreach ($cart as $key => $item) {
            // Verify and recalculate price from database
            $product = Product::find($item['product_id']);
            if ($product) {
                $correctPrice = $product->getPriceForVariant($item['size'] ?? null, $item['color'] ?? null);
                $quantity = (int) $item['quantity'];
                
                $cartItems[] = [
                    'key' => $key,
                    'name' => $item['name'],
                    'image' => $item['image'],
                    'size' => $item['size'] ?? 'Standard',
                    'color' => $item['color'] ?? 'Standard',
                    'price' => $correctPrice,
                    'quantity' => $quantity,
                    'subtotal' => $correctPrice * $quantity
                ];
                
                $subtotal += $correctPrice * $quantity;
                
                // Update cart session with correct price if different
                if (abs($item['price'] - $correctPrice) > 1) {
                    $cart[$key]['price'] = $correctPrice;
                }
            }
        }
        
        // Update session with corrected prices
        session()->put('cart', $cart);
        
        $shippingFee = $subtotal >= 500000 ? 0 : 30000; // Free shipping over 500k
        $total = $subtotal + $shippingFee;
        
        // Auto-fill user data if logged in
        $user = Auth::user();
        
        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingFee', 'total', 'user'));
    }

    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'payment_method' => 'required',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Giỏ hàng trống'], 400);
        }
        
        // Calculate totals again to be safe
        $subtotal = 0;
        foreach ($cart as $item) {
             $subtotal += (float)$item['price'] * (int)$item['quantity'];
        }
        $shippingFee = $subtotal >= 500000 ? 0 : 30000;
        $total = $subtotal + $shippingFee;
        
        $order = \App\Models\Order::create([
            'user_id' => Auth::id(), // Link order to user
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address . ', ' . $request->district . ', ' . $request->city,
            'note' => $request->note,
            'payment_method' => $request->payment_method,
            'total_amount' => $total,
            'deposit_amount' => $request->payment_method === 'deposit' ? round($total * 0.3) : 0,
            'items' => array_values($cart) // Save as array
        ]);
        
        // Clear Cart
        session()->forget('cart');
        session()->save(); // Force save
        
        return response()->json([
            'success' => true, 
            'message' => 'Đặt hàng thành công',
            'order_id' => $order->id
        ]);
    }
}
