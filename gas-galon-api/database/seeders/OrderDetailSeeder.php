<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::first();
        $product = Product::first();

        if ($order && $product) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 2,
                'price' => $product->price,
                'subtotal' => $product->price * 2,
            ]);
        }
    }
}
