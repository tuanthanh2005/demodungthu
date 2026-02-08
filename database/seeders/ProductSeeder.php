<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'Áo Thun Nam Basic Cotton',
                'slug' => 'ao-thun-nam-basic-cotton',
                'description' => 'Áo thun nam chất liệu cotton 100%, thoáng mát, thấm hút mồ hôi tốt',
                'price' => 245000,
                'quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['#000000', '#FFFFFF', '#1E3A8A', '#DC2626'],
                'in_stock' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Áo Thun Nữ Form Rộng',
                'slug' => 'ao-thun-nu-form-rong',
                'description' => 'Áo thun nữ form rộng, phong cách Hàn Quốc, chất liệu mềm mại',
                'price' => 199000,
                'quantity' => 0, // Hết hàng
                'image' => 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400',
                'sizes' => ['M', 'L', 'XL'],
                'colors' => ['#FFFFFF', '#FFC0CB', '#E0E0E0'],
                'in_stock' => false,
            ],
            [
                'category_id' => 2,
                'name' => 'Áo Sơ Mi Nam Công Sở',
                'slug' => 'ao-so-mi-nam-cong-so',
                'description' => 'Áo sơ mi nam công sở, chất liệu cao cấp, không nhăn',
                'price' => 320000,
                'quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=400',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'colors' => ['#FFFFFF', '#87CEEB', '#FFB6C1'],
                'in_stock' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Quần Jean Nam Skinny',
                'slug' => 'quan-jean-nam-skinny',
                'description' => 'Quần jean nam form skinny, co giãn tốt, ôm dáng',
                'price' => 450000,
                'quantity' => 3, // Sắp hết hàng
                'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400',
                'sizes' => ['28', '29', '30', '31', '32'],
                'colors' => ['#1E3A8A', '#000000', '#808080'],
                'in_stock' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Váy Maxi Hoa Nhí Vintage',
                'slug' => 'vay-maxi-hoa-nhi-vintage',
                'description' => 'Váy maxi hoa nhí phong cách vintage, nhẹ nhàng, nữ tính',
                'price' => 550000,
                'quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=400',
                'sizes' => ['S', 'M', 'L'],
                'colors' => ['#FFC0CB', '#FFFFFF', '#FFD700'],
                'in_stock' => true,
            ],
            [
                'category_id' => 5,
                'name' => 'Giày Thể Thao Nam Cao Cấp',
                'slug' => 'giay-the-thao-nam-cao-cap',
                'description' => 'Giày thể thao nam, đế êm, thoáng khí, phù hợp vận động',
                'price' => 675000,
                'quantity' => 0, // Hết hàng
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400',
                'sizes' => ['39', '40', '41', '42', '43'],
                'colors' => ['#000000', '#FFFFFF', '#DC2626'],
                'in_stock' => false,
            ],
            [
                'category_id' => 6,
                'name' => 'Túi Xách Nữ Da Cao Cấp',
                'slug' => 'tui-xach-nu-da-cao-cap',
                'description' => 'Túi xách nữ da PU cao cấp, thiết kế sang trọng',
                'price' => 540000,
                'quantity' => 15,
                'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400',
                'sizes' => [],
                'colors' => ['#000000', '#8B4513', '#DC143C'],
                'in_stock' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Quần Jean Nữ Ống Rộng',
                'slug' => 'quan-jean-nu-ong-rong',
                'description' => 'Quần jean nữ ống rộng, phong cách Hàn Quốc, thoải mái',
                'price' => 380000,
                'quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=400',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['#1E3A8A', '#000000'],
                'in_stock' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
