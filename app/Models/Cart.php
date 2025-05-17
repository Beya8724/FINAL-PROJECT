<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Define relationship with User
    public function user()
    {
        return $this->belongsTo(User::class); // A cart belongs to one user
    }

    // Define relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class); // A cart belongs to one product
    }
}
