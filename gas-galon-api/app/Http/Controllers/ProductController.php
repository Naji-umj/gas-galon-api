<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::with('seller')->get();

        return response()->json([
            'message' => 'Daftar produk berhasil diambil',
            'data' => $products
        ]);
    }

    
    public function show($id)
    {
        $product = Product::with('seller')->findOrFail($id);

        return response()->json([
            'message' => 'Detail produk berhasil diambil',
            'data' => $product
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'seller_id' => 'required|exists:users,id',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product->load('seller')
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:100',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Produk berhasil diperbarui',
            'data' => $product
        ]);
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}
