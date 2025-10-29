<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;

class PaymentController extends Controller
{
    
    public function index()
    {
        $payments = Payment::with('order.customer')->get();

        return response()->json([
            'message' => 'Daftar pembayaran berhasil diambil',
            'data' => $payments
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'method' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0',
        ]);

        $payment = Payment::create([
            'order_id' => $validated['order_id'],
            'method' => $validated['method'],
            'amount' => $validated['amount'],
            'status' => 'paid',
        ]);

        $order = Order::find($validated['order_id']);
        $order->update(['status' => 'processing']);

        return response()->json([
            'message' => 'Pembayaran berhasil dibuat',
            'data' => $payment->load('order')
        ], 201);
    }
}
