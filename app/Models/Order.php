<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'product_id',
        'price',
        'way',
        'status',
        'tracking',
        'payment_status',
        'payment_method',
        'gcash_picture',
        'gcash_reference_number',
        'delivery_address',
        'ordered_at',
        'delivered_at'
    ];

    // Define relationships to the User and Product models
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
