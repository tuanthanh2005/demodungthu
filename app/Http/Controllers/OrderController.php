<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Store a new order
     */
    public function store(Request $request)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
                'customer_address' => 'required|string|max:500',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
            ]);

            // Begin transaction
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'total' => $validated['total'],
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($validated['items'] as $item) {
                // Verify product exists and price matches
                $product = Product::find($item['product_id']);
                
                if (!$product) {
                    throw new \Exception("Product not found: {$item['product_id']}");
                }

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Commit transaction
            DB::commit();

            // Log successful order
            Log::info('Order created successfully', [
                'order_id' => $order->id,
                'customer_email' => $order->customer_email,
                'total' => $order->total
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công!',
                'order_id' => $order->id,
                'order' => $order->load('items.product')
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order details
     */
    public function show($id)
    {
        try {
            $order = Order::with('items.product')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'order' => $order
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng'
            ], 404);
        }
    }

    /**
     * Get all orders
     */
    public function index()
    {
        try {
            $orders = Order::with('items.product')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($orders);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể tải danh sách đơn hàng'
            ], 500);
        }
    }

    /**
     * Get orders for the current user
     */
    public function myOrders(Request $request)
    {
        try {
            $user = $request->user();

            $orders = Order::with('items.product')
                ->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->orWhere('customer_email', $user->email);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($orders);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'KhÃ´ng thá»ƒ táº£i Ä‘Æ¡n hÃ ng cá»§a báº¡n'
            ], 500);
        }
    }
}
