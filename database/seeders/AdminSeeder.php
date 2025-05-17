<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;  // Assuming you have an Admin model.

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create a default admin account
        Admin::create([
            'email' => 'admin@example.com', // Replace with your admin email
            'password' => Hash::make('123456789'), // Make sure the password is hashed
        ]);
    }
}
