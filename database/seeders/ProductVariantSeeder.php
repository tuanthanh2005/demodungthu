<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        // Tìm một sản phẩm thời trang (giả sử có category_id = 2)
        $fashionProduct = Product::where('category_id', 2)->first();
        
        if ($fashionProduct) {
            // Thêm variants cho sản phẩm thời trang (size + màu)
            $sizes = ['S', 'M', 'L', 'XL'];
            $colors = ['Đỏ', 'Xanh', 'Đen', 'Trắng'];
            
            foreach ($colors as $color) {
                foreach ($sizes as $size) {
                    $priceAdjustment = match($size) {
                        'S' => 0,
                        'M' => 20000,
                        'L' => 40000,
                        'XL' => 60000,
                        default => 0
                    };
                    
                    ProductVariant::create([
                        'product_id' => $fashionProduct->id,
                        'size' => $size,
                        'color' => $color,
                        'price' => $fashionProduct->price + $priceAdjustment,
                        'stock' => rand(10, 50),
                        'sku' => 'FASHION-' . $fashionProduct->id . '-' . $size . '-' . $color
                    ]);
                }
            }
        }
        
        // Tìm sản phẩm điện tử (giả sử có category_id = 1)
        $electronicsProduct = Product::where('category_id', 1)->first();
        
        if ($electronicsProduct) {
            // Thêm variants cho điện tử (dung lượng + màu)
            $capacities = ['64GB', '128GB', '256GB', '512GB'];
            $colors = ['Đen', 'Trắng', 'Xanh', 'Vàng'];
            
            foreach ($colors as $color) {
                foreach ($capacities as $capacity) {
                    $priceAdjustment = match($capacity) {
                        '64GB' => 0,
                        '128GB' => 2000000,
                        '256GB' => 4000000,
                        '512GB' => 7000000,
                        default => 0
                    };
                    
                    ProductVariant::create([
                        'product_id' => $electronicsProduct->id,
                        'size' => $capacity,
                        'color' => $color,
                        'price' => $electronicsProduct->price + $priceAdjustment,
                        'stock' => rand(5, 30),
                        'sku' => 'ELEC-' . $electronicsProduct->id . '-' . $capacity . '-' . $color
                    ]);
                }
            }
        }
    }
}
