<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create User (nếu chưa tồn tại)
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Create Categories
        $categories = [
            ['name' => 'Điện Tử', 'description' => 'Các sản phẩm điện tử'],
            ['name' => 'Thời Trang', 'description' => 'Quần áo, giày dép'],
            ['name' => 'Gia Dụng', 'description' => 'Đồ dùng gia đình'],
            ['name' => 'Sách', 'description' => 'Sách và tài liệu'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create sample products
        $products = [
            [
                'category_id' => 1,
                'name' => 'Laptop Dell XPS 13',
                'description' => 'Laptop cao cấp với hiệu năng mạnh mẽ',
                'price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=500&h=400&fit=crop',
                'main_image' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=500&h=400&fit=crop',
            ],
            [
                'category_id' => 1,
                'name' => 'iPhone 15 Pro',
                'description' => 'Điện thoại thông minh cao cấp nhất',
                'price' => 30000,
                'image' => 'https://images.unsplash.com/photo-1592286927505-4a1d1c4e0c9e?w=500&h=400&fit=crop',
                'main_image' => 'https://images.unsplash.com/photo-1592286927505-4a1d1c4e0c9e?w=500&h=400&fit=crop',
            ],
            [
                'category_id' => 2,
                'name' => 'Áo Thun Cotton',
                'description' => 'Áo thun thoải mái 100% cotton',
                'price' => 350,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=400&fit=crop',
                'main_image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=400&fit=crop',
            ],
            [
                'category_id' => 3,
                'name' => 'Bàn Ăn Gỗ',
                'description' => 'Bàn ăn gỗ tự nhiên cao cấp',
                'price' => 5000,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500&h=400&fit=crop',
                'main_image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500&h=400&fit=crop',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
