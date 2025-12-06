<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
    ['email' => 'admin@campusmarket.com'],
    [
        'name' => 'Admin CampusMarket',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
        'phone' => '081234567890',
        'email_verified_at' => now(),
        'approval_status' => 'approved',
        'approved_at' => now(),
    ]
);


        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@campusmarket.com');
        $this->command->info('Password: admin123');
    }
}
