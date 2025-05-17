<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function DashboardPage(Request $request)
    {
        // Manually check if the logged-in user is an admin using the 'admin' guard
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            // If the user is not an admin, log them out and redirect to the login page
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page.');
        }

        // If the user is an admin, show the admin dashboard
        return view('admin.dashboard');
    }
}
