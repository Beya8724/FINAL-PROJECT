<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class PlacedOrderController extends Controller
{
    public function showOrderForm()
    {
        // Ensure the user is logged in
        if (Auth::check()) {
            $user = Auth::user();

            // Get the user's cart items
            $cartItems = Cart::where('user_id', $user->id)->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
            }

            return view('users.placed_order', compact('cartItems', 'user'));
        }

        return redirect()->route('users.login')->with('error', 'Please login to place an order.');
    }

    // Method to place an order
    public function placeOrder(Request $request)
    {
        // Ensure the user is logged in
        if (Auth::check()) {
            $user = Auth::user();

            // Get the user's cart items
            $cartItems = Cart::where('user_id', $user->id)->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
            }

            // Validate gcash picture if payment method is gcash
            if ($request->payment_method === 'gcash') {
                $request->validate([
                    'gcash_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'gcash_reference_number' => 'required|string|max:255',
                ]);
            }

            // Store GCash image if exists
            $gcashPath = null;
            if ($request->hasFile('gcash_picture')) {
                $gcashPath = $request->file('gcash_picture')->store('gcash_uploads', 'public');
            }

            // Generate a unique order code
            $orderCode = 'ORDER-' . Str::random(10);

            foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem->product_id);

                Order::create([
                    'user_id' => $user->id,
                    'way' => $request->delivery_method,
                    'order_code' => $orderCode,
                    'product_id' => $cartItem->product_id,
                    'price' => $product->product_price * $cartItem->quantity,
                    'status' => 'pending',
                    'tracking' => 'processing',
                    'payment_status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'gcash_picture' => $gcashPath, // Save path only
                    'gcash_reference_number' => $request->gcash_reference_number,
                    'delivery_address' => $request->delivery_address,
                    'ordered_at' => now(),
                    'delivered_at' => null,
                ]);
            }

            // Clear the cart
            Cart::where('user_id', $user->id)->delete();

            return redirect()->route('cart.show')->with('success', 'Order placed successfully!');
        } else {
            return redirect()->route('users.login')->with('error', 'Please login to place an order.');
        }
    }
}
