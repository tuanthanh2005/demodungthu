<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    // Lấy tất cả variants của một sản phẩm
    public function index($productId)
    {
        $variants = ProductVariant::where('product_id', $productId)->get();
        return response()->json($variants);
    }

    // Tạo variant mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100'
        ]);

        $variant = ProductVariant::create($validated);
        return response()->json($variant, 201);
    }

    // Cập nhật variant
    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $validated = $request->validate([
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100'
        ]);

        $variant->update($validated);
        return response()->json($variant);
    }

    // Xóa variant
    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();
        return response()->json(['message' => 'Variant đã được xóa']);
    }

    // Tạo nhiều variants cùng lúc
    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variants' => 'required|array',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.sku' => 'nullable|string|max:100'
        ]);

        $createdVariants = [];
        foreach ($validated['variants'] as $variantData) {
            $variantData['product_id'] = $validated['product_id'];
            $createdVariants[] = ProductVariant::create($variantData);
        }

        return response()->json($createdVariants, 201);
    }
}
