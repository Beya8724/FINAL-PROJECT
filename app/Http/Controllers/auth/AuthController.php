<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function UsersLoginPage()
    {
        return view('users.login');
    }

    public function LoginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home.page');
        }

        return back()->with('error', 'Invalid credentials. Please try again.');
    }

    public function AdminLoginPage()
    {
        return view('admin.login');
    }

    public function AdminLoginSubmit(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to find an admin with the provided email
        $admin = Admin::where('email', $credentials['email'])->first();

        // Check if the admin exists and the password is correct
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            // Log the admin in using the 'admin' guard
            Auth::guard('admin')->login($admin);

            // Regenerate the session ID to prevent session fixation
            $request->session()->regenerate();

            // Redirect to the admin dashboard
            return redirect()->route('admin.dashboard');
        }

        // If credentials are invalid or not an admin, show an error message
        return back()->with('error', 'Invalid credentials or you are not authorized to access this panel.');
    }

    // Logout method for the admin
    public function AdminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function RegisterPage()
    {
        return view('users.register');
    }

    public function RegisterSubmit(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'address' => 'required|string|max:1000',
            'contact' => 'required|string|max:50',
        ]);

        User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'contact' => $request->contact,
        ]);

        return redirect()->route('users.register')->with('success', 'Registration successful! You can now log in.');
    }

    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home')->with('success', 'Logged out successfully.');
    }
}
