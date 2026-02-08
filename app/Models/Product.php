<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'regular_price',
        'sale_price',
        'discount_percentage',
        'image',
        'images',
        'in_stock',
        'slug',
        'detail',
        'specs',
        'quantity',
        'sizes',
        'colors',
        'size_prices',
        'color_prices'
    ];

    protected $casts = [
        'images' => 'array',
        'specs' => 'array',
        'sizes' => 'array',
        'colors' => 'array',
        'size_prices' => 'array',
        'color_prices' => 'array',
        'in_stock' => 'boolean',
        'quantity' => 'integer',
        'regular_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'discount_percentage' => 'integer'
    ];

    /**
     * Relationship with Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Check if product is available
     */
    public function isAvailable()
    {
        return $this->in_stock && $this->quantity > 0;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return number_format((float)$this->price, 0, ',', '.') . ' đ';
    }

    /**
     * Unified price accessor (sale_price when available, otherwise regular_price)
     */
    public function getPriceAttribute()
    {
        if (!is_null($this->sale_price) && (float)$this->sale_price > 0) {
            return $this->sale_price;
        }

        return $this->regular_price;
    }

    /**
     * Scope for available products
     */
    public function scopeAvailable($query)
    {
        return $query->where('in_stock', true)->where('quantity', '>', 0);
    }

    /**
     * Scope for out of stock products
     */
    public function scopeOutOfStock($query)
    {
        return $query->where(function($q) {
            $q->where('in_stock', false)
              ->orWhere('quantity', '<=', 0);
        });
    }
}
