<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::updateOrCreate(
            ['email' => 'admin@deancell.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create Kasir
        User::updateOrCreate(
            ['email' => 'kasir@deancell.com'],
            [
                'name' => 'Kasir Utama',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ]
        );
    }
}
