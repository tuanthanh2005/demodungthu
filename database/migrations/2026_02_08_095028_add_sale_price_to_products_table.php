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
            // Đổi tên cột 'price' thành 'regular_price' (giá tiêu chuẩn)
            $table->renameColumn('price', 'regular_price');
            
            // Thêm cột 'sale_price' (giá đã giảm)
            $table->decimal('sale_price', 10, 2)->nullable()->after('regular_price');
            
            // Thêm cột 'discount_percentage' (% giảm giá) - tự động tính
            $table->integer('discount_percentage')->nullable()->after('sale_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('regular_price', 'price');
            $table->dropColumn(['sale_price', 'discount_percentage']);
        });
    }
};
