<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'manufacturer_id',
        'name',
        'email',
        'phone',
        'logistics_details',
        'location',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
}
