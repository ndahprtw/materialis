<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $no = 1;
        $data_pelanggan = Pelanggan::orderBy('nama_pelanggan')->get();  // Perbaikan nama variabel menjadi $data_pelanggan
        return view('pages.data-pelanggan.index', compact('no', 'data_pelanggan'));  // Konsistensi variabel di compact()
    }

    public function create()
    {
        return view('pages.pelanggan.create'); // Arahkan ke view form create
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat_pelanggan' => 'required|string|max:255',
        ]);

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nama_pelanggan' => 'required|string|max:255',
        'alamat_pelanggan' => 'required|string|max:255',
    ]);

    $pelanggan = Pelanggan::findOrFail($id);
    $pelanggan->update($validated);

    return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
}

    public function destroy($id)
    {
        $data_pelanggan = Pelanggan::findOrFail($id);
        $data_pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Produk berhasil dihapus.');
    }

}
