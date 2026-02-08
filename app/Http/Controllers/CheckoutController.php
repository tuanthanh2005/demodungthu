<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
        
        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingFee', 'total'));
    }
}
