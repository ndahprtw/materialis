<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailPermintaan;
use App\Models\Permintaan;
use App\Models\Product;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    public function index()
    {
        $no = 1;
        $title = 'Permintaan Materian';
        if (auth()->user()->role == 'Staff Proyek') {
            $data = Permintaan::where('id_staff_gudang', auth()->user()->id)->orderBy('tanggal_permintaan', 'desc')->get();
        } else {
            $data = Permintaan::where('status', "!=", 'dalam pengajuan')->get();
        }
        
        return view('pages.permintaan.index', compact('no', 'title', 'data'));
    }

    public function store(Request $request)
    {
        Permintaan::create([
            'tanggal_permintaan' => now(),
            'id_staff_gudang' => $request->id_staff_gudang,
            'id_staff_proyek' => null,
            'catatan' => null,
            'status' => 'dalam pengajuan',
        ]);

        return redirect()->route('permintaan.index')->with('success', 'Permintaan material berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {

        $data = Permintaan::findOrFail($id);

        if ($request->status == 'diajukan') {
            $data->update([
                'status'  => 'diajukan',
            ]);

            return redirect()->back()->with('success', 'Permintaan material berhasil diajukan.');
        } elseif ($request->status == 'diproses') {
            $data->update([
                'status'  => 'diproses',
                'id_staff_proyek' => auth()->user()->id,
            ]);

            return redirect()->back()->with('success', 'Permintaan pengajuan material berhasil dilakukan.');
        } elseif ($request->status == 'selesai') {
            $data->update([
                'status'  => 'selesai',
                'catatan' => 'permintaan telah diproses dan selesai',
            ]);

            return redirect()->back()->with('success', 'Permintaan pengajuan material selesai diproses.');
        }

    }

    public function show($id)
    {
        $no = 1;
        $title = 'Permintaan Materian';
        $materials = Product::all();
        $data = Permintaan::findOrFail($id);
        $detail_data = DetailPermintaan::where('id_permintaan', $id)->get();
        return view('pages.permintaan.show', compact('no', 'title', 'data', 'materials', 'detail_data'));
    }

    public function destroy($id)
    {
        $data = Permintaan::findOrFail($id);
        $detail_data = DetailPermintaan::where('id_permintaan', $id)->get();
        
        if ($data->delete()) {
            foreach ($detail_data as $detail) {
                $detail->delete();
            }
            return redirect()->back()->with('success', 'Data permintaan material berhasil dibatalkan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data');
        }
    }

}
