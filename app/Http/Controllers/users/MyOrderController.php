<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class MyOrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch all orders for the logged-in user, grouped by order_code
        $orders = Order::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('order_code'); // Grouping similar to admin

        return view('users.my_orders', compact('user', 'orders'));
    }
}
