<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột size_prices để lưu giá theo size
            // Format: {"S": {"price": 200000, "quantity": 10}, "M": {"price": 220000, "quantity": 5}}
            $table->json('size_prices')->nullable()->after('sizes');
            
            // Thêm cột color_prices để lưu giá theo màu
            // Format: {"#FF0000": {"price": 250000, "quantity": 3}, "#00FF00": {"price": 280000, "quantity": 7}}
            $table->json('color_prices')->nullable()->after('colors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['size_prices', 'color_prices']);
        });
    }
};
