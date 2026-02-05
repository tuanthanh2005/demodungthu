<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Láº¥y danh sÃ¡ch sáº£n pháº©m
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->get();
        return response()->json($products);
    }

    // Láº¥y thÃ´ng tin 1 sáº£n pháº©m
    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json(['error' => 'Sáº£n pháº©m khÃ´ng tá»“n táº¡i'], 404);
        }

        return response()->json($product);
    }

    // Láº¥y thÃ´ng tin sáº£n pháº©m theo slug
    public function showBySlug($slug)
    {
        $product = Product::with(['category', 'variants'])->where('slug', $slug)->first();

        if (!$product) {
            return response()->json(['error' => 'Sáº£n pháº©m khÃ´ng tá»“n táº¡i'], 404);
        }

        return response()->json($product);
    }

    // Trang chi tiáº¿t sáº£n pháº©m
    public function detailPage($slug)
    {
        return view('product-detail', ['slug' => $slug]);
    }

    // Táº¡o sáº£n pháº©m má»›i
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'detail_description' => 'nullable|string',
            'specs' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|string',
            'main_image' => 'nullable|string',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'string',
            'image_alt' => 'nullable|string|max:255',
        ]);

        // Ensure additional_images is always an array
        if (isset($validated['additional_images'])) {
            $validated['additional_images'] = is_array($validated['additional_images'])
                ? $validated['additional_images']
                : (json_decode($validated['additional_images'], true) ?: []);
        }

        $validated['slug'] = $this->generateUniqueSlug($validated['name']);

        $product = Product::create($validated);
        $product->load('category');
        return response()->json($product, 201);
    }

    // Cáº­p nháº­t sáº£n pháº©m
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Sáº£n pháº©m khÃ´ng tá»“n táº¡i'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'detail_description' => 'nullable|string',
            'specs' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'in_stock' => 'sometimes|in:0,1,true,false',
            'image' => 'nullable|string',
            'main_image' => 'nullable|string',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'string',
            'image_alt' => 'nullable|string|max:255',
        ]);

        // Convert in_stock to boolean
        if (isset($validated['in_stock'])) {
            $validated['in_stock'] = filter_var($validated['in_stock'], FILTER_VALIDATE_BOOLEAN);
        }

        // Ensure additional_images is always an array
        if (isset($validated['additional_images'])) {
            $validated['additional_images'] = is_array($validated['additional_images'])
                ? $validated['additional_images']
                : (json_decode($validated['additional_images'], true) ?: []);
        }

        if (isset($validated['name']) && $validated['name'] !== $product->name) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name'], $product->id);
        } elseif (!$product->slug) {
            $validated['slug'] = $this->generateUniqueSlug($product->name, $product->id);
        }

        $product->update($validated);
        $product->load('category');
        return response()->json($product);
    }

    // XÃ³a sáº£n pháº©m
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Sáº£n pháº©m khÃ´ng tá»“n táº¡i'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'XÃ³a sáº£n pháº©m thÃ nh cÃ´ng']);
    }

    // Láº¥y danh sÃ¡ch danh má»¥c
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Upload image
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Tạo tên file unique
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Lưu vào public/images
                $path = $image->move(public_path('images'), $filename);
                
                // Trả về URL
                $url = asset('images/' . $filename);
                
                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'filename' => $filename
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy file'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi upload: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        if ($base === '') {
            $base = 'product';
        }

        $slug = $base;
        $i = 2;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, function ($query, $ignoreId) {
                    return $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $base . '-' . $i;
            $i++;
        }

        return $slug;
    }
}
