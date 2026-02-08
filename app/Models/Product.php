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

    /**
     * Get price for specific variant (size + color)
     * Returns the variant price if exists, otherwise returns base price
     */
    public function getPriceForVariant($size = null, $color = null)
    {
        $basePrice = $this->sale_price > 0 ? $this->sale_price : $this->regular_price;
        
        // Check size price first
        if ($size && !empty($this->size_prices)) {
            foreach ($this->size_prices as $sizeData) {
                if (isset($sizeData['size']) && $sizeData['size'] === $size && isset($sizeData['price'])) {
                    $basePrice = (float) $sizeData['price'];
                    break;
                }
            }
        }
        
        // Check color price (can override or add to size price)
        if ($color && !empty($this->color_prices)) {
            foreach ($this->color_prices as $colorData) {
                // Match by hex color or name
                if ((isset($colorData['hex']) && $colorData['hex'] === $color) || 
                    (isset($colorData['name']) && $colorData['name'] === $color)) {
                    if (isset($colorData['price']) && $colorData['price'] > 0) {
                        $basePrice = (float) $colorData['price'];
                    }
                    break;
                }
            }
        }
        
        return $basePrice;
    }
}
