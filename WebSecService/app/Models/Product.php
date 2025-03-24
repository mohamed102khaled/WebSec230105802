<?php
 namespace App\Models;
 use Illuminate\Database\Eloquent\Model;
 class Product extends Model {
    protected $table = "products";
    protected $fillable = [
        'code',
        'name',
        'price',
        'model',
        'description',
        'photo'
    ];

    public function buyers()
{
    return $this->belongsToMany(User::class, 'bought_products')
                ->withPivot('quantity', 'total_price', 'status')
                ->withTimestamps();
}
 }