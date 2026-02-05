<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Lấy danh sách danh mục
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('created_at', 'desc')->get();
        return response()->json($categories);
    }

    // Lấy thông tin 1 danh mục
    public function show($id)
    {
        $category = Category::withCount('products')->find($id);
        
        if (!$category) {
            return response()->json(['error' => 'Danh mục không tồn tại'], 404);
        }
        
        return response()->json($category);
    }

    // Tạo danh mục mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    // Cập nhật danh mục
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        
        if (!$category) {
            return response()->json(['error' => 'Danh mục không tồn tại'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);
        return response()->json($category);
    }

    // Xóa danh mục
    public function destroy($id)
    {
        $category = Category::find($id);
        
        if (!$category) {
            return response()->json(['error' => 'Danh mục không tồn tại'], 404);
        }

        // Check if category has products
        if ($category->products()->count() > 0) {
            return response()->json(['error' => 'Không thể xóa danh mục có sản phẩm'], 400);
        }

        $category->delete();
        return response()->json(['message' => 'Xóa danh mục thành công']);
    }
}
