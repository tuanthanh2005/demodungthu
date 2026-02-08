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
     * Logic: CỘNG DỒN = Giá gốc + Phụ thu size + Phụ thu màu
     */
    public function getPriceForVariant($size = null, $color = null)
    {
        $basePrice = $this->sale_price > 0 ? (float)$this->sale_price : (float)$this->regular_price;
        $sizeExtra = 0;
        $colorExtra = 0;
        
        // Normalize inputs for comparison
        $normalizedSize = $size ? strtolower(trim($size)) : null;
        $normalizedColor = $color ? strtolower(trim($color)) : null;
        
        // Get size extra price
        if ($normalizedSize && $normalizedSize !== 'standard' && !empty($this->size_prices)) {
            foreach ($this->size_prices as $key => $sizeData) {
                // Handle both array and object formats
                $sizeValue = isset($sizeData['size']) ? strtolower(trim($sizeData['size'])) : strtolower(trim($key));
                if ($sizeValue === $normalizedSize && isset($sizeData['price']) && (float)$sizeData['price'] > 0) {
                    $sizeExtra = (float) $sizeData['price'];
                    break;
                }
            }
        }
        
        // Get color extra price
        if ($normalizedColor && $normalizedColor !== 'standard' && !empty($this->color_prices)) {
            foreach ($this->color_prices as $key => $colorData) {
                // Match by hex color, name, or key (case-insensitive)
                $colorHex = isset($colorData['hex']) ? strtolower(trim($colorData['hex'])) : '';
                $colorName = isset($colorData['name']) ? strtolower(trim($colorData['name'])) : strtolower(trim($key));
                
                if (($colorHex === $normalizedColor || $colorName === $normalizedColor)) {
                    if (isset($colorData['price']) && (float)$colorData['price'] > 0) {
                        $colorExtra = (float) $colorData['price'];
                    }
                    break;
                }
            }
        }
        
        // CỘNG DỒN: Giá gốc + Phụ thu size + Phụ thu màu
        return $basePrice + $sizeExtra + $colorExtra;
    }
}
