<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Inventory;
use App\Models\Pelacakan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        // dd($request);
        // $request->validate([
        //     'email' => 'required',
        //     'password'=> 'required' 
        //  ], [
        //     'email.required' => 'Kolom Email tidak boleh kosong.',
        //     'password.required' => 'Kolom Password tidak boleh kosong.',
        // ]);


         if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            
            if ($user->role === 'Admin' || $user->role === 'Karyawan') {
                return redirect('/dashboard');
            } elseif($user->role === 'Kurir') {
                return redirect('/pelacakan');
            } else {
                return redirect('/')->with('wrong', 'Role tidak Ditemukan !');
            }
        } else {
            return redirect('/')->with('wrong', 'Email dan password tidak tersedia');
        }
    }

    public function logout() {
        if (Auth::check()) {
            $role = Auth::user()->role;
    
           if ($role === 'Admin' || $role === 'Karyawan') {
                Auth::logout();
            }
        } 
        return redirect('/');
    }

    public function dashboard(Request $request)
    {
        $karyawan = User::where('role', 'Karyawan')->count();
        $pemasukan = Inventory::where('jenis', 'barang masuk')->sum('pembayaran');
        $pengeluaran = Inventory::where('jenis', 'barang keluar')->sum('pembayaran');

        // Mengambil daftar tahun dari tabel inventories
        $daftarTahun = Inventory::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
    
        // Mendapatkan tahun yang dipilih atau tahun saat ini
        $tahunIni = $request->input('tahun', Carbon::now()->year);
    
        // Mengambil total harga barang keluar per bulan di tahun yang dipilih
        $totalHargaBarangKeluarPerBulan = Inventory::where('jenis', 'barang keluar')
            ->whereYear('inventories.created_at', $tahunIni)
            ->join('products', 'inventories.id_produk', '=', 'products.id')
            ->selectRaw('MONTH(inventories.created_at) as bulan, SUM(products.harga_produk * inventories.jumlah_barang) as total_harga')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
    
        // Mengambil total harga barang masuk per bulan di tahun yang dipilih
        $totalHargaBarangMasukPerBulan = Inventory::where('jenis', 'barang masuk')
            ->whereYear('inventories.created_at', $tahunIni)
            ->join('products', 'inventories.id_produk', '=', 'products.id')
            ->selectRaw('MONTH(inventories.created_at) as bulan, SUM(products.harga_produk * inventories.jumlah_barang) as total_harga')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
    
        // Memastikan bulan terurut
        $bulanBarang = collect(range(1, 12))->map(function($month) {
            return Carbon::create()->month($month)->format('F');
        });
    
        // Mempersiapkan data untuk setiap bulan
        $data_total_harga_keluar = array_fill(0, 12, 0);
        $data_total_harga_masuk = array_fill(0, 12, 0);
    
        // Memasukkan data keluar
        foreach ($totalHargaBarangKeluarPerBulan as $barangKeluar) {
            $data_total_harga_keluar[$barangKeluar->bulan - 1] = $barangKeluar->total_harga;
        }
    
        // Memasukkan data masuk
        foreach ($totalHargaBarangMasukPerBulan as $barangMasuk) {
            $data_total_harga_masuk[$barangMasuk->bulan - 1] = $barangMasuk->total_harga;
        }

        // status pelacakan
        $cek_status = Pelacakan::where('status', '!=', 'selesai')->count();
        $status_pelacakan = Pelacakan::selectRaw('status, COUNT(*) as banyak_status')
        ->where('status', '!=', 'selesai')
        ->groupBy('status')
        ->orderBy('status')
        ->get();

        $status = [];
        $data = [];

        foreach ($status_pelacakan as $item) {
            $status[] = $item->status;
            $data[] = $item->banyak_status;
        }

        // produk per sales
        $jumlahProdukPerSales = Product::selectRaw('id_sales, COUNT(*) as jumlah_produk')
            ->groupBy('id_sales')
            ->orderBy('id_sales')
            ->get();

        // Mempersiapkan data untuk grafik
        $data_sales = [];
        $banyak_produk = [];

        foreach ($jumlahProdukPerSales as $produk) {
            $sales = Sales::find($produk->id_sales);
            if ($sales) {
                $data_sales[] = $sales->nama;
                $banyak_produk[] = $produk->jumlah_produk;
            }
        }
    
        // Mengirim data ke view
        return view('pages.dashboard', compact('karyawan', 'pemasukan', 'pengeluaran', 'bulanBarang', 'data_total_harga_keluar', 'data_total_harga_masuk', 'tahunIni', 'daftarTahun', 'cek_status', 'status', 'data', 'data_sales', 'banyak_produk'));
    }
}
