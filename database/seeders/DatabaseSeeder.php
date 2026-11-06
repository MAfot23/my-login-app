<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create or update Default Administrator
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Administrator',
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );

        // 2. Create or update Standard Demo User
        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'password' => Hash::make('password123'),
                'is_admin' => false,
            ]
        );

        // 3. Initial Activity Logs
        ActivityLog::firstOrCreate(
            ['action' => 'SYSTEM_INIT', 'description' => 'System initialized with admin and default users.'],
            [
                'user_id' => $admin->id,
                'username' => $admin->username,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'System Seeder',
            ]
        );

        ActivityLog::create([
            'user_id' => $admin->id,
            'username' => $admin->username,
            'action' => 'LOGIN',
            'description' => 'Admin admin logged in successfully.',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'action' => 'REGISTER',
            'description' => 'New user registered: johndoe (user@example.com)',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        ]);
    }
}
