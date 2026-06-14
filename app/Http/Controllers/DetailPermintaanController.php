<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailPermintaan;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DetailPermintaanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'material' => 'required',
            'jumlah' => 'required',
        ]);

        $produk = Product::findOrFail($request->material);

        DetailPermintaan::create([
            'id_permintaan' => $request->id_permintaan,
            'id_produk' => $request->material,
            'jumlah_permintaan' => $request->jumlah,
        ]);

        if ($request->jumlah > $produk->stok_produk) {
            return redirect()->back()->with('error', 'Stok ' . $produk->nama_produk . ' saat ini tersisa ' . $produk->stok_produk . '. Permintaan Anda berpotensi mengalami keterlambatan.');
        } else {
            return redirect()->back()->with('success', 'Bahan Material berhasil ditambahkan');
        }
        

    }

    public function destroy($id)
    {
        $data = DetailPermintaan::findOrFail($id);
        if ($data->delete()) {
            return redirect()->back()->with('success', 'Data Material berhasil dihapus dari permintaan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data');
        }
    }

    public function update(Request $request, $id)
    {
        $data = DetailPermintaan::findOrFail($id);
        $produk = Product::findOrFail($data->id_produk);
        $user = User::findOrFail($request->staff_proyek);

        if ($request->status == 'stok tersedia') {
            $data->update([
                'status'  => 'stok tersedia',
                'pesan' => 'Permintaan material dengan jumlah ' . $data->jumlah_permintaan . ' diterima',
            ]);

            $aliran_barang = new Inventory();
            $aliran_barang->jenis = 'barang keluar';
            $aliran_barang->jumlah_barang = $data->jumlah_permintaan;
            $aliran_barang->pembayaran = 0;
            $aliran_barang->id_produk = $data->id_produk;
            $aliran_barang->id_karyawan = auth()->user()->id;
            $aliran_barang->pesan = 'Permintaan material dengan jumlah ' . $data->jumlah_permintaan . ' oleh Staff Proyek : ' . $user->name;
            $aliran_barang->save();
            
            $produk->decrement('stok_produk', $data->jumlah_permintaan);
            return redirect()->back()->with('success', 'Permintaan material berhasil diterima.');

        } elseif ($request->status == 'stok tidak tersedia') {
            $data->update([
                'status'  => 'stok tidak tersedia',
                'pesan' => 'Permintaan ditolak. Saat ini stok tersisa ' . $produk->stok_produk . ' dari ' . $data->jumlah_permintaan,
            ]);

            return redirect()->back()->with('success', 'Permintaan material berhasil ditolak.');
        }

    }
}
