<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoughtProduct extends Model
{
    protected $table = 'bought_products'; // Explicitly define table
    protected $fillable = [
        'user_id',
        'product_id',
        'status_message',
        'quantity',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

