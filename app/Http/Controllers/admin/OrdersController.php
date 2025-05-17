<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a list of unique orders grouped by order_code.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Group by order_code and select the minimum id as representative for each group,
        // and LEFT JOIN to get user information along with 'way' column and 'status' column.
        $orders = DB::table('orders')
            ->select(
                'orders.order_code',
                DB::raw('MIN(orders.id) as id'),
                'orders.payment_method',
                'orders.payment_status',
                'orders.way',  // Ensure 'way' is selected
                'orders.status',  // Ensure 'status' is selected
                DB::raw('MIN(orders.tracking) as tracking'),  // Aggregate 'tracking' field
                'users.fullname as customer_name',
                'users.contact as customer_contact'
            )
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->groupBy(
                'orders.order_code',
                'users.fullname',
                'users.contact',
                'orders.payment_method',
                'orders.payment_status',
                'orders.way',
                'orders.status'
            )  // No need to group by 'tracking' now
            ->orderByDesc('id')
            ->get();

        return view('admin.orders', compact('orders'));
    }


    /**
     * View full order details by order_code.
     *
     * @param string $order_code
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function viewOrderDetails($order_code)
    {
        // Get all orders for a specific order_code along with user and product info
        $orders = DB::table('orders')
            ->select(
                'orders.*',  // All fields from the orders table
                'users.fullname as customer_name',
                'users.contact as customer_contact',
                'products.product_name',  // Selecting product_name from the products table
                'products.product_price'  // Selecting product_price from the products table
            )
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')  // Join the products table on the product_id
            ->where('orders.order_code', $order_code)
            ->get();

        if ($orders->isEmpty()) {
            return redirect()->route('admin.orders')->with('error', 'Order not found.');
        }

        // Calculate total price for the orders
        $totalPrice = $orders->sum('price');  // Summing the price of orders
        $user = $orders->first();  // Get the user information

        return view('admin.view_orders', compact('orders', 'totalPrice', 'user'));
    }

    public function updateOrderDetails(Request $request, $order_code)
    {
        // Validation uses lowercase values to match the actual DB
        $validated = $request->validate([
            'payment_status' => 'required|string|in:paid,unpaid',
            'tracking' => 'required|string|in:on the way,completed',
        ]);

        // Find one of the orders with the order_code (to update the whole group)
        $orders = Order::where('order_code', $order_code)->get();

        if ($orders->isEmpty()) {
            return redirect()->route('admin.orders')->with('error', 'Order not found.');
        }

        // Loop through and update each order in the group
        foreach ($orders as $order) {
            $order->payment_status = $validated['payment_status'];
            $order->tracking = $validated['tracking'];

            // Logic: if both paid & completed, set status to "completed"
            if ($validated['payment_status'] === 'paid' && $validated['tracking'] === 'completed') {
                $order->status = 'completed';
            } else {
                $order->status = 'pending'; // Or keep previous value if you prefer
            }

            $order->save();
        }

        return redirect()->route('admin.orders.view', $order_code)->with('success', 'Order updated successfully.');
    }
}
