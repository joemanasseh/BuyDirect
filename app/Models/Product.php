<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'product_type', // 'bulk' for individual bulk buy, 'merge' for merge buy
        'minimum_order_quantity', // For bulk buy
        'available_quantity',
        'manufacturer_id',
        'merge_buy_limit', // For merge buy
        'merge_buy_price', // For merge buy
        'merge_buy_quantity', // For merge buy
        'merge_buy_city', // Optional: city-specific merge buy
    ];

    /**
     * A product belongs to one manufacturer.
     */
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    /**
     * A product can have many orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scope to filter bulk buy products.
     */
    public function scopeBulk($query)
    {
        return $query->where('product_type', 'bulk');
    }

    /**
     * Scope to filter merge buy products.
     */
    public function scopeMerge($query)
    {
        return $query->where('product_type', 'merge');
    }
}
