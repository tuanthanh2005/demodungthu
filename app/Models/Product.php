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
        'slug',
        'description',
        'detail_description',
        'specs',
        'price',
        'in_stock',
        'image',
        'main_image',
        'additional_images',
        'image_alt',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'additional_images' => 'array',
        'in_stock' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
