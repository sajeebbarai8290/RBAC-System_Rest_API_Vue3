<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Admin', 
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123456')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $manager = User::create([
            'name' => 'Manager', 
            'email' => 'manager@gmail.com',
            'password' => Hash::make('manager123456')
        ]);
        $manager->assignRole('Manager');

        // Creating Product Manager User
        $user = User::create([
            'name' => 'User', 
            'email' => 'user@gmail.com',
            'password' => Hash::make('user123456')
        ]);
        $user->assignRole('User');
    }
}