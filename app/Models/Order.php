<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'address', 'note',
        'total_amount', 'deposit_amount', 'payment_method', 'status', 'items'
    ];
    
    protected $casts = [
        'items' => 'array',
    ];
}
