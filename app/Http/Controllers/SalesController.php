<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $no = 1;
        $title = 'Data Sales';
        $data = Sales::orderBy('nama')->get(); 
        return view('pages.data-sales.index', compact('no', 'data', 'title')); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|integer',
        ]);

        Sales::create($validated);

        return redirect()->route('data-sales.index')->with('success', 'Data sales berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|integer',
        ]);

        $sales = Sales::findOrFail($id);
        $sales->update($validated);

        return redirect()->route('data-sales.index')->with('success', 'Data sales berhasil diperbarui.');
    }

    public function destroy($id) {  
        $data = Sales::find($id);

        $cek_produk = Product::where('id_sales', $id)->count();
        if ($cek_produk > 0) {
            return redirect()->back()->with('warning', 'Data ' . $data->nama . ' memiliki ' . $data->produk->count() . ' data produk terkait');
        } else {
            if ($data->delete()){
                return redirect()->back()->with('success', 'Data berhasil dihapus!');
            } else {
                return redirect()->back()->with('error', 'Gagal menghapus data');
            } 
        }  
    }
}
