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
        $title = 'Data Supplier';
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



    public function destroy($id)
    {
        $data = Sales::findOrFail($id);
        $data->delete();

        return redirect()
            ->route('data-sales.index')
            ->with('success', 'Data pegawai berhasil dihapus!');
    }
}
