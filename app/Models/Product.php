<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category',
        'product_image',
        'product_name',
        'product_price',
        'product_stocks',
        'product_status',
    ];
}
