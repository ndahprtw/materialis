<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $no = 1;
        $title = 'Inventory';
        $produk = Product::all();

        $query = Inventory::query();

        // ✅ Filter range tanggal
        if ($request->tanggal_dari && $request->tanggal_sampai) {
            $query->whereBetween('created_at', [
                $request->tanggal_dari . ' 00:00:00',
                $request->tanggal_sampai . ' 23:59:59'
            ]);
        }

        // Filter jenis
        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        // Filter produk
        if ($request->produk) {
            $query->where('id_produk', $request->produk);
        }

        $data = $query->get();

        return view('pages.inventory.index', compact('no', 'title', 'data', 'produk'));
    }

    public function create()
    {
        $title = 'Inventory';
        $produk = Product::all();
        return view('pages.inventory.create', compact('title', 'produk'));
    }

    public function store(Request $request)
    {
        // dd($request);    
        $request->validate([
            'produk' => 'required',
            'jumlah_barang' => 'required',
            'jenis' => 'required',
        ]);

        $jenis = $request->jenis;

        $aliran_barang = new Inventory();
        $aliran_barang->jenis = $jenis;
        $aliran_barang->jumlah_barang = $request->jumlah_barang;
        $aliran_barang->pembayaran = $request->total_harga;
        $aliran_barang->id_produk = $request->produk;
        $aliran_barang->id_karyawan = auth()->user()->id;
        $aliran_barang->pesan = $request->pesan;

        $produk = Product::findOrFail($request->produk);


        if ($request->jenis === 'barang masuk') {
            if ($aliran_barang->save()) {
                $produk->increment('stok_produk', $request->jumlah_barang);
                return redirect()->route('inventory.index')->with('success', 'Data berhasil disimpan!');
            } else {
                return redirect()->route('inventory.index')->with('error', 'Gagal menyimpan data');
            }
        } else {
            if ($produk->stok_produk >= $request->jumlah_barang) {
                if ($aliran_barang->save()) {
                    $produk->decrement('stok_produk', $request->jumlah_barang);
                    return redirect()->route('inventory.index')->with('success', 'Data berhasil disimpan!');
                } else {
                    return redirect()->route('inventory.index')->with('error', 'Gagal menyimpan data');
                }
            } else {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk produk ' . $produk->nama_produk . ' !');
            }
        }
    }

    public function laporan()
    {
        $title = 'Laporan';
        $data = Inventory::select(
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as jumlah')
        )->groupBy('tahun', 'bulan')->get();
        return view('pages.inventory.laporan', compact('title', 'data'));
    }

    public function unduh_laporan($tahun, $bulan)
    {
        $data = Inventory::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->get();

        return view('pages.inventory.download', compact('data', 'tahun', 'bulan'));
    }

    public function download(Request $request)
    {
        $data = Inventory::query();

        // filter tanggal
        if ($request->tanggal_dari) {
            $data->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->tanggal_sampai) {
            $data->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        // filter jenis
        if ($request->jenis) {
            $data->where('jenis', $request->jenis);
        }

        // filter produk
        if ($request->produk) {
            $data->where('id_produk', $request->produk);
        }

        $data = $data->get();

        return view('pages.inventory.filter-download', compact('data'));
    }
}
