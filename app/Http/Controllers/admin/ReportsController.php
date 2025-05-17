<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function ReportsPage()
    {
        // Get today's date
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek(); // Start of this week (Monday)
        $startOfMonth = Carbon::now()->startOfMonth(); // Start of this month

        // Fetch completed orders for daily report
        $dailyOrders = DB::table('orders')
            ->where('status', 'completed')
            ->whereDate('created_at', '=', $today)
            ->count();

        // Fetch completed orders for weekly report
        $weeklyOrders = DB::table('orders')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startOfWeek, Carbon::now()])
            ->count();

        // Fetch completed orders for monthly report
        $monthlyOrders = DB::table('orders')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startOfMonth, Carbon::now()])
            ->count();

        // Return view with report data
        return view('admin.reports', compact('dailyOrders', 'weeklyOrders', 'monthlyOrders'));
    }

    public function printDailyReport()
    {
        $today = Carbon::today();
        $orders = DB::table('orders')
            ->select('order_code', DB::raw('SUM(price) as total_price'))
            ->where('status', 'completed')
            ->whereDate('created_at', $today)
            ->groupBy('order_code')
            ->get();

        return view('admin.daily', compact('orders'));
    }

    public function printWeeklyReport()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $now = Carbon::now();
        $orders = DB::table('orders')
            ->select('order_code', DB::raw('SUM(price) as total_price'))
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startOfWeek, $now])
            ->groupBy('order_code')
            ->get();

        return view('admin.weekly', compact('orders'));
    }

    public function printMonthlyReport()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $now = Carbon::now();
        $orders = DB::table('orders')
            ->select('order_code', DB::raw('SUM(price) as total_price'))
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startOfMonth, $now])
            ->groupBy('order_code')
            ->get();

        return view('admin.monthly', compact('orders'));
    }
}
