<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Method to add items to the cart
    public function addToCart(Request $request, $productId)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $product = Product::find($productId);

            if ($product) {
                // Check if product has stock
                if ($product->product_stocks <= 0) {
                    return redirect()->route('product.page')->with('error', 'Sorry, this product is out of stock.');
                }

                // Check if the product is already in the cart
                $existingCartItem = Cart::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->first();

                if ($existingCartItem) {
                    if ($product->product_stocks < ($existingCartItem->quantity + 1)) {
                        return redirect()->route('product.page')->with('error', 'Not enough stock available.');
                    }

                    $existingCartItem->quantity += 1;
                    $existingCartItem->save();
                } else {
                    Cart::create([
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'quantity' => 1,
                    ]);
                }

                // Reduce product stock
                $product->product_stocks -= 1;

                // Update product_status
                if ($product->product_stocks <= 0) {
                    $product->product_status = 'Not Available';
                } elseif ($product->product_stocks <= 4) {
                    $product->product_status = 'Low Stock';
                } else {
                    $product->product_status = 'Available';
                }

                $product->save();

                return redirect()->route('product.page')->with('success', 'Product added to cart!');
            } else {
                return redirect()->route('product.page')->with('error', 'Product not found.');
            }
        } else {
            return redirect()->route('users.login')->with('error', 'Please login to add to cart.');
        }
    }



    // Method to display the cart
    public function showCart()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Get all the cart items for the authenticated user
            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

            return view('users.cart', compact('cartItems'));
        } else {
            return redirect()->route('users.login')->with('error', 'Please login to view your cart.');
        }
    }

    // Method to delete an item from the cart
    public function deleteFromCart($cartItemId)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Find the cart item by ID and ensure it's owned by the authenticated user
            $cartItem = Cart::where('user_id', $user->id)->where('id', $cartItemId)->first();

            if ($cartItem) {
                // Delete the cart item
                $cartItem->delete();

                return redirect()->route('cart.show')->with('success', 'Item removed from your cart.');
            } else {
                return redirect()->route('cart.show')->with('error', 'Item not found in your cart.');
            }
        } else {
            return redirect()->route('users.login')->with('error', 'Please login to remove items from your cart.');
        }
    }
}
