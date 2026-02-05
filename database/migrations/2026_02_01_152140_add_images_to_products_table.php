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
            $table->text('main_image')->nullable()->after('image'); // Ảnh chính
            $table->json('additional_images')->nullable()->after('main_image'); // Array ảnh phụ
            $table->text('image_alt')->nullable()->after('additional_images'); // Alt text cho ảnh chính
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('main_image');
            $table->dropColumn('additional_images');
            $table->dropColumn('image_alt');
        });
    }
};
