<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'driver', 'orderDetail.product', 'payment'])->get();

        return response()->json([
            'message' => 'Daftar pesanan berhasil diambil',
            'data' => $orders
        ]);
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'driver', 'orderDetail.product', 'payment'])->findOrFail($id);

        return response()->json([
            'message' => 'Detail pesanan berhasil diambil',
            'data' => $order
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'      => 'required|exists:users,id',
            'driver_id'        => 'nullable|exists:users,id',
            'product_id'       => 'required|exists:products,id',
            'quantity'         => 'required|integer|min:1',
            'delivery_address' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $product  = Product::findOrFail($validated['product_id']);
            $subtotal = $product->price * $validated['quantity'];

            $detail = OrderDetail::create([
                'product_id' => $product->id,
                'quantity'   => $validated['quantity'],
                'price'      => $product->price,
                'subtotal'   => $subtotal,
            ]);

            $order = Order::create([
                'customer_id'      => $validated['customer_id'],
                'driver_id'        => $validated['driver_id'] ?? null,
                'order_detail_id'  => $detail->id,
                'order_date'       => now(),
                'status'           => 'processing',
                'total_price'      => $subtotal,
                'delivery_address' => $validated['delivery_address'],
            ]);

            $product->decrement('stock', $validated['quantity']);

            DB::commit();

            return response()->json([
                'message' => 'Pesanan berhasil dibuat',
                'data' => $order->load(['orderDetail.product', 'customer', 'driver'])
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal membuat pesanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'Status pesanan berhasil diperbarui',
            'data' => $order
        ]);
    }


    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'message' => 'Pesanan berhasil dihapus'
        ]);
    }
}
