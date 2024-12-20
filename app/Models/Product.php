<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

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
        'participants', // For merge buy participants
        'created_by', // For audit trail
        'updated_by' // For audit trail
    ];

    /**
     * Default relationships to always eager load.
     */
    protected $with = ['manufacturer'];

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
     * A product can have many participants (for merge buy).
     */
    public function participants()
    {
        return $this->hasMany(Participant::class); // Assuming Participant model exists for merge buy participants
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

    /**
     * Scope to filter products by city.
     */
    public function scopeByCity($query, $city)
    {
        return $query->where('merge_buy_city', $city);
    }

    /**
     * Set the merge buy quantity attribute.
     */
    public function setMergeBuyQuantityAttribute($value)
    {
        if ($this->merge_buy_limit && $this->available_quantity) {
            $this->attributes['merge_buy_quantity'] = $this->available_quantity / $this->merge_buy_limit;
        }
    }

    /**
     * Accessor for formatted price.
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Calculate merge buy price based on participants.
     */
    public function calculateMergeBuyPrice()
    {
        if ($this->product_type === 'merge' && $this->participants > 0) {
            $this->merge_buy_price = $this->price / $this->participants;
        }
    }

    /**
     * Calculate merge buy limit based on participants.
     */
    public function calculateMergeBuyLimit()
    {
        if ($this->product_type === 'merge' && $this->participants > 0) {
            $this->merge_buy_limit = $this->merge_buy_quantity / $this->participants;
        }
    }
}
