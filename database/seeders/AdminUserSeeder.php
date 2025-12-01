<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
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
        // Get or create super admin role
        $superAdminRole = Role::where('slug', 'super-admin')->first();

        // Create admin user with super admin role
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@digitalmediaplus.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'role_id' => $superAdminRole?->id,
        ]);

        // Create test user
        User::create([
            'name' => 'Test User',
            'email' => 'user@digitalmediaplus.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
