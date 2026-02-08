<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'image' => 'nullable|image|max:10240', // 10MB max, all image types
            'thumbnails.*' => 'nullable|image|max:10240', // 10MB max per image, all types
            'size_prices' => 'nullable|array',
            'size_prices.*.price' => 'nullable|numeric|min:0',
            'size_prices.*.quantity' => 'nullable|integer|min:0',
            'color_prices' => 'nullable|array',
            'color_prices.*.hex' => 'nullable|string',
            'color_prices.*.price' => 'nullable|numeric|min:0',
            'color_prices.*.quantity' => 'nullable|integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            // Store in public_uploads disk (server: public_html)
            $path = $image->storeAs('uploads/products', $imageName, 'public_uploads');
            $validated['image'] = '/uploads/products/' . $imageName;
        }

        // Handle multiple thumbnail images
        if ($request->hasFile('thumbnails')) {
            $thumbnails = [];
            foreach ($request->file('thumbnails') as $index => $thumbnail) {
                $thumbnailName = time() . '_thumb_' . $index . '_' . $thumbnail->getClientOriginalName();
                
                // Store in public_uploads disk (server: public_html)
                $thumbnail->storeAs('uploads/products', $thumbnailName, 'public_uploads');
                $thumbnails[] = '/uploads/products/' . $thumbnailName;
            }
            $validated['images'] = $thumbnails;
        }

        $validated['slug'] = Str::slug($validated['name']);
        
        // Calculate total quantity from variants
        $totalQuantity = 0;
        if (!empty($validated['size_prices'])) {
            foreach ($validated['size_prices'] as $variant) {
                $totalQuantity += $variant['quantity'] ?? 0;
            }
        }
        if (!empty($validated['color_prices'])) {
            foreach ($validated['color_prices'] as $variant) {
                $totalQuantity += $variant['quantity'] ?? 0;
            }
        }
        
        $validated['quantity'] = $totalQuantity;
        $validated['in_stock'] = $totalQuantity > 0;
        
        // Extract sizes and colors from variant data
        if (!empty($validated['size_prices'])) {
            $validated['sizes'] = array_keys($validated['size_prices']);
        }
        if (!empty($validated['color_prices'])) {
            // Store color names as array, hex values in color_prices
            $validated['colors'] = array_keys($validated['color_prices']);
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|string',
            'sizes' => 'nullable|array',
            'colors' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['in_stock'] = $validated['quantity'] > 0;

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa thành công!');
    }

    /**
     * Update product quantity
     */
    public function updateQuantity(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $product->update([
            'quantity' => $validated['quantity'],
            'in_stock' => $validated['quantity'] > 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Số lượng đã được cập nhật',
            'quantity' => $product->quantity,
            'in_stock' => $product->in_stock
        ]);
    }
}
