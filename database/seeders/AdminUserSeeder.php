<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if doesn't exist
        $adminUser = User::where('email', 'admin@reciperipple.com')->first();

        if (!$adminUser) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@reciperipple.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'google_id' => 'admin_local',
                'email_verified_at' => now(),
            ]);

            echo "Admin user created successfully!\n";
            echo "Email: admin@reciperipple.com\n";
            echo "Password: admin123\n";
        } else {
            // Update existing user to admin
            $adminUser->update(['role' => 'admin']);
            echo "Existing user updated to admin role!\n";
        }
    }
}
