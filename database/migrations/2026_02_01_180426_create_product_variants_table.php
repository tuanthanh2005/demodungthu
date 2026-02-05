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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('size')->nullable(); // S, M, L, XL, 32GB, 64GB, etc
            $table->string('color')->nullable(); // Đỏ, Xanh, Đen, Trắng, etc
            $table->decimal('price', 15, 2); // Giá cho variant này
            $table->integer('stock')->default(0); // Số lượng tồn kho
            $table->string('sku')->nullable(); // Mã SKU riêng
            $table->timestamps();
            
            // Index để tìm kiếm nhanh
            $table->index(['product_id', 'size', 'color']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
