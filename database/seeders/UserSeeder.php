<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create specific instructor user
        User::create([
            'name' => 'John Doe',
            'email' => 'student@example.com',
            'password' => Hash::make('password123'),
            'country' => 'London',
            'role' => 'student',

        ]);

        // Create random users with mixed roles
        \App\Models\User::factory()->count(50)->create();
    }
}
