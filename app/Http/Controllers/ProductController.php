<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Pelacakan;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $no = 1;
        $data_product = Product::orderBy('nama_produk')->get();
        $sales = Sales::orderBy('nama')->get();
        return view('pages.data-product.index', compact('no', 'data_product', 'sales'));
    }

    public function create()
    {
        return view('pages.data-product.create'); // Arahkan ke view form create
    }

    // Metode untuk menyimpan data produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string',
            'nama_sales' => 'required',
            'harga_produk' => 'required|numeric',
            'stok_produk' => 'required|integer',
        ]);

        Product::create([
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            'stok_produk' => $request->stok_produk,
            'id_sales' => $request->nama_sales,
        ]);

        return redirect()->route('data-product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data_product = Product::findOrFail($id);
        return view('pages.data-product.edit', compact('product'));
    }

    // Memperbarui data produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string',
            'nama_sales' => 'required',
            'harga_produk' => 'required|numeric',
            'stok_produk' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            'stok_produk' => $request->stok_produk,
            'id_sales' => $request->nama_sales,
        ]);

        return redirect()->route('data-product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $cek_inventory = Inventory::where('id_produk', $id)->count();
        $cek_pelacakan = Pelacakan::where('id_produk', $id)->count();
        if ($cek_inventory > 0 || $cek_pelacakan > 0) {
            return redirect()->back()->with('warning', 'Data ' . $product->nama . ' masih digunakan di fitur lain');
        } else {
            if ($product->delete()){
                return redirect()->back()->with('success', 'Data berhasil dihapus!');
            } else {
                return redirect()->back()->with('error', 'Gagal menghapus data');
            } 
        }  
    }

}
