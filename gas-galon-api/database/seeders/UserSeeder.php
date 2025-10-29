<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin NFAcademy',
            'email' => 'admin@nfacademy.com',
            'password' => Hash::make('admin123'),
            'phone_number' => '081234567890',
            'role' => 'admin',
            'address' => 'Kantor Pusat Bekasi',
        ]);

        User::create([
            'name' => 'Agen Gas & Galon',
            'email' => 'seller@nfacademy.com',
            'password' => Hash::make('seller123'),
            'phone_number' => '081234567891',
            'role' => 'seller',
            'address' => 'Jl. Ahmad Yani No.10',
        ]);

        User::create([
            'name' => 'Driver 1',
            'email' => 'driver@nfacademy.com',
            'password' => Hash::make('driver123'),
            'phone_number' => '081234567892',
            'role' => 'driver',
            'address' => 'Jl. Raya Bekasi Timur',
        ]);

        User::create([
            'name' => 'Customer Pertama',
            'email' => 'customer@nfacademy.com',
            'password' => Hash::make('customer123'),
            'phone_number' => '081234567893',
            'role' => 'user',
            'address' => 'Jl. Melati No.45',
        ]);
    }
}
