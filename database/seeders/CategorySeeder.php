<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Áo thun', 'slug' => 'ao-thun', 'description' => 'Áo thun nam nữ', 'icon' => 'fa-tshirt'],
            ['name' => 'Áo sơ mi', 'slug' => 'ao-so-mi', 'description' => 'Áo sơ mi công sở', 'icon' => 'fa-shirt'],
            ['name' => 'Quần jean', 'slug' => 'quan-jean', 'description' => 'Quần jean nam nữ', 'icon' => 'fa-jeans'],
            ['name' => 'Váy', 'slug' => 'vay', 'description' => 'Váy nữ các loại', 'icon' => 'fa-dress'],
            ['name' => 'Giày dép', 'slug' => 'giay-dep', 'description' => 'Giày dép thời trang', 'icon' => 'fa-shoe-prints'],
            ['name' => 'Túi xách', 'slug' => 'tui-xach', 'description' => 'Túi xách thời trang', 'icon' => 'fa-bag-shopping'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
