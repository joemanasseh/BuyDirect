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
     * Define a relationship: A manufacturer has many participants through products.
     */
    public function participants()
    {
        return $this->hasManyThrough(Participant::class, Product::class);
    }

    /**
     * Get all individual bulk buy products.
     */
    public function individualBulkBuyProducts()
    {
        return $this->products()->where('product_type', 'bulk');
    }

    /**
     * Get all merge buy products.
     */
    public function mergeBuyProducts()
    {
        return $this->products()->where('product_type', 'merge');
    }

    /**
     * Define a relationship: A manufacturer has many participants for merge buy products.
     */
    public function mergeBuyParticipants()
    {
        return $this->hasManyThrough(Participant::class, Product::class)
            ->where('product_type', 'merge');
    }
}
