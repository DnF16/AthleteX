<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an Admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin', 
        ]);

        // Create a Coach/User
        User::factory()->create([
            'name' => 'Delson',
            'email' => 'delson@gmail.com',
            'password' => bcrypt('coach123'),
            'role' => 'coach', 
        ]);
    }
}
