<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::where('role', 'seller')->first();

        Product::insert([
            [
                'name' => 'Gas Elpiji 3 Kg',
                'price' => 22000,
                'stock' => 50,
                'seller_id' => $seller->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gas Elpiji 12 Kg',
                'price' => 160000,
                'stock' => 20,
                'seller_id' => $seller->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Galon Aqua 19L',
                'price' => 18000,
                'stock' => 40,
                'seller_id' => $seller->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
