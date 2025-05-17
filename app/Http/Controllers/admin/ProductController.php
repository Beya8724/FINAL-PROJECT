<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function AdminProductPage()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }


    public function AddProduct(Request $request)
    {
        $validated = $request->validate([
            'product_category' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_price' => 'required|numeric|min:0',
            'product_stocks' => 'required|integer|min:0',
        ]);

        $imagePath = $request->file('product_image')->store('products', 'public');

        $status = match (true) {
            $validated['product_stocks'] == 0 => 'Not Available',
            $validated['product_stocks'] <= 4 => 'Low Stock',
            default => 'Available',
        };

        Product::create([
            'product_category' => $validated['product_category'],
            'product_name' => $validated['product_name'],
            'product_image' => $imagePath,
            'product_price' => $validated['product_price'],
            'product_stocks' => $validated['product_stocks'],
            'product_status' => $status,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }
}
