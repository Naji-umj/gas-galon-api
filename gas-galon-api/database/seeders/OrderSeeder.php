<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('role', 'user')->first();
        $driver   = User::where('role', 'driver')->first();
        $product  = Product::first();

        if (!$customer || !$driver || !$product) {
            return;
        }

        $order = Order::create([
            'customer_id'      => $customer->id,
            'driver_id'        => $driver->id,
            'order_detail_id'  => null,
            'order_date'       => now(),
            'status'           => 'processing',
            'total_price'      => $product->price * 2,
            'delivery_address' => $customer->address ?? 'Jl. Contoh No. 10',
        ]);

        $detail = OrderDetail::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => 2,
            'price'      => $product->price,
            'subtotal'   => $product->price * 2,
        ]);

        $order->update([
            'order_detail_id' => $detail->idOrder_details,
        ]);
    }
}
