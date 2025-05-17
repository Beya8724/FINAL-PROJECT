<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function ShopPage()
    {
        $products = Product::where('product_status', '!=', 'Not Available')->get();
        return view('users.shop', compact('products'));
    }
}
