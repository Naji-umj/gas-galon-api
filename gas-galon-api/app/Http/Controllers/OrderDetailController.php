<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderDetailController extends Controller
{
    
    public function index()
    {
        $details = OrderDetail::with(['order.customer', 'product'])->get();

        return response()->json([
            'message' => 'Daftar detail pesanan berhasil diambil',
            'data' => $details
        ]);
    }

    public function show($id)
    {
        $detail = OrderDetail::with(['order.customer', 'product'])->findOrFail($id);

        return response()->json([
            'message' => 'Detail pesanan berhasil diambil',
            'data' => $detail
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($validated['product_id']);
            $subtotal = $product->price * $validated['quantity'];

            $detail = OrderDetail::create([
                'order_id' => $validated['order_id'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ]);

            $order = Order::find($validated['order_id']);
            $order->update([
                'total_price' => $order->orderDetails()->sum('subtotal')
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Detail pesanan berhasil ditambahkan',
                'data' => $detail->load(['product', 'order'])
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menambahkan detail pesanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $detail = OrderDetail::findOrFail($id);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = $detail->price * $validated['quantity'];
            $detail->update([
                'quantity' => $validated['quantity'],
                'subtotal' => $subtotal,
            ]);

            $order = $detail->order;
            $order->update([
                'total_price' => $order->orderDetails()->sum('subtotal')
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Detail pesanan berhasil diperbarui',
                'data' => $detail->load(['product', 'order'])
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal memperbarui detail pesanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $detail = OrderDetail::findOrFail($id);

        DB::beginTransaction();
        try {
            $order = $detail->order;
            $detail->delete();

            $order->update([
                'total_price' => $order->orderDetails()->sum('subtotal')
            ]);

            DB::commit();

            return response()->json(['message' => 'Detail pesanan berhasil dihapus']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menghapus detail pesanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
