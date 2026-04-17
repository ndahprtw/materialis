<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Pelacakan;
use App\Models\Pelanggan;
use App\Models\Product;
use Illuminate\Http\Request;

class PelacakanController extends Controller
{
    public function index(Request $request)
    {
        $no = 1;
        $title = 'Pelacakan';
    
        // Ambil filter dari request
        $tanggal = $request->input('tanggal');
        $status = $request->input('jenis');
    
        // Mulai query untuk mengambil data pelacakan
        $query = Pelacakan::query();
    
        // Filter berdasarkan tanggal jika ada
        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }
    
        // Filter berdasarkan status jika ada
        if ($status) {
            $query->where('status', $status);
        }
    
        // Ambil semua data atau yang sudah difilter
        $data = $query->get();

        $data_kurir = Pelacakan::where('status','!=','dikemas')->get();
    
        return view('pages.pelacakan.index', compact('no', 'title', 'data', 'data_kurir'));
    }
    

    public function create()
    {
        $title = 'Pelacakan';
        $produk = Product::all();
        $customer = Pelanggan::all();
        return view('pages.pelacakan.create', compact('title', 'produk', 'customer'));
    }

    public function store(Request $request) {
        // dd($request);    
        $request->validate([
            'produk' => 'required',
            'jumlah_barang' => 'required',
            'customer' => 'required',
        ]);

        $pelacakan = new Pelacakan();
        $pelacakan->id_karyawan = auth()->user()->id;
        $pelacakan->id_customer = $request->customer;
        $pelacakan->id_produk = $request->produk;
        $pelacakan->jumlah_barang = $request->jumlah_barang;
        $pelacakan->total = $request->total;
        $pelacakan->status = 'dikemas';
        $pelacakan->bukti = null;

        $produk = Product::findOrFail($request->produk);
        $customer = Pelanggan::findOrFail($request->customer);


        if ($produk->stok_produk >= $request->jumlah_barang) {
            if ($pelacakan->save()) {
                $produk->decrement('stok_produk', $request->jumlah_barang);
                
                $aliran_barang = new Inventory();
                $aliran_barang->jenis = 'barang keluar';
                $aliran_barang->jumlah_barang = $request->jumlah_barang;
                $aliran_barang->id_produk = $request->produk;
                $aliran_barang->id_karyawan = auth()->user()->id;
                $aliran_barang->pesan = "Pembelian " . $produk->nama_produk . " oleh " . $customer->nama_pelanggan;
                $aliran_barang->pembayaran = $request->total;
                $aliran_barang->save();

                $pelacakan->id_inventory = $aliran_barang->id;
                $pelacakan->save();

                return redirect()->route('pelacakan.index')->with('success', 'Data berhasil disimpan!');
            } else {
                return redirect()->route('pelacakan.index')->with('error', 'Gagal menyimpan data');
            }
        } else {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk produk ' . $produk->nama_produk . ' !');
        }
    }

    public function update1($id) {
        $update = Pelacakan::findOrFail($id);
        $update->status = 'dikirim';

        if ($update->save()) {
            return redirect()->back()->with('success', 'Status berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate status');
        }

    }

    public function update2($id) {
        $update = Pelacakan::findOrFail($id);
        $update->status = 'dibatalkan';

        if ($update->save()) {
            $produk = Product::findOrFail($update->id_produk);
            $produk->increment('stok_produk', $update->jumlah_barang);

            $inventory = Inventory::where('id', $update->id_inventory)->first();
            $inventory->pembayaran = 0;
            $inventory->pesan = "Produk dibatalkan oleh customer";
            $inventory->save();

            return redirect()->back()->with('success', 'Status berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate status');
        }

    }

    public function update($id, Request $request) {
        // dd($request);    
        if ($request->file('bukti')) {
            $request->validate([
                'bukti' => 'required',
            ]);
    
            $bukti = $request->file('bukti');
            $imageName = now()->format('YmdHis') . '.' . $bukti->extension();
            $bukti->move(public_path('assets/img/bukti/'), $imageName);
    
            $update = Pelacakan::findOrFail($id);
            $update->id_kurir = auth()->user()->id;
            $update->status = 'selesai';
            $update->bukti = $imageName;
    
            if ($update->save()) {
                return redirect()->back()->with('success', 'Status berhasil diperbarui!');
            } else {
                return redirect()->back()->with('error', 'Gagal mengupdate status');
            }
        } elseif ($request->has('pembayaran')) {
            $request->validate([
                'pembayaran' => 'required',
                'sisa' => 'required',
            ]);

            $update = Pelacakan::findOrFail($id);
            $update->jumlah_pelunasan = $request->pembayaran;
            $update->sisa_pelunasan = $request->sisa;

            if ($update->save()) {
                return redirect()->back()->with('success', 'Pembayaran berhasil diperbarui!');
            } else {
                return redirect()->back()->with('error', 'Gagal mengupdate pembayaran');
            }
        } else {
            $request->validate([
                'pembayaran_sisa' => 'required',
                'sisa_pembayaran' => 'required',
            ]);

            $update = Pelacakan::findOrFail($id);
            $pelunasan_sebelumnya = $update->jumlah_pelunasan;
            $update_pelunasan = $pelunasan_sebelumnya + $request->pembayaran_sisa; 
            $update->jumlah_pelunasan = $update_pelunasan;
            $update->sisa_pelunasan = $request->sisa_pembayaran;

            if ($update->save()) {
                return redirect()->back()->with('success', 'Pembayaran berhasil diperbarui!');
            } else {
                return redirect()->back()->with('error', 'Gagal mengupdate pembayaran');
            }
        }
        
    }

}
