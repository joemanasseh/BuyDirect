<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'buyer_id', 
        'quantity', 
        'status', 
        'order_type', 
        'merge_buy_quantity_per_buyer',
    ];

    // An order belongs to one product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // An order belongs to one buyer (assuming buyer is a user or customer)
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
