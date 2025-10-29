<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Order;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::first();

        Payment::create([
            'order_id' => $order->id,
            'method' => 'Transfer Bank',
            'amount' => $order->total_price,
            'status' => 'paid',
        ]);
    }
}
