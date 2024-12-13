<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'email',
        'phone',
        'address',
        'rating',
        'review',
    ];

    /**
     * Define a relationship: A manufacturer has many products.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all individual bulk buy products.
     */
    public function individualBulkBuyProducts()
    {
        return $this->products()->where('product_type', 'bulk_buy');
    }

    /**
     * Get all buy merge products.
     */
    public function buyMergeProducts()
    {
        return $this->products()->where('product_type', 'merge_buy');
    }
}
