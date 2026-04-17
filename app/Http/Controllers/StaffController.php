<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $no = 1;
        $data = User::orderBy('name')->get();
        $karyawan = User::where('role','Karyawan')->count();
        $admin = User::where('role','Admin')->count();
        return view('pages.data-staff.index', compact('no', 'data', 'karyawan', 'admin'));
    }

    public function create()
    {
        return view('pages.data-staff.create'); // Arahkan ke view form create
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users',
            'role' => 'required',
            'password' => 'required'
        ]);

       if ($request->hasFile('profile')) {
        $profile = $request->file('profile');
        $imageName = now()->format('YmdHis') . $request->email . '.' . $profile->extension();
        $profile->move(public_path('assets/img/profile/'), $imageName);
       } else {
        $imageName=null;
       }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'profile' => $imageName ,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('data-staff.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);
    
        // Arahkan ke view form edit dan kirimkan data user yang ditemukan
        return view('pages.data-staff.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email,' . $id, // email harus unik kecuali user ini
            'role' => 'required',
        ]);
    
        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);
    
        // Jika ada file profile diupload
        if ($request->hasFile('profile')) {
            // Upload dan ganti gambar profil
            $profile = $request->file('profile');
            $imageName = now()->format('YmdHis') . $request->email . '.' . $profile->extension();
            $profile->move(public_path('assets/img/profile/'), $imageName);
    
            // Hapus file profil lama jika ada
            if ($user->profile) {
                $oldProfile = public_path('assets/img/profile/') . $user->profile;
                if (file_exists($oldProfile)) {
                    unlink($oldProfile);
                }
            }
        } else {
            // Jika tidak ada upload, gunakan profil lama
            $imageName = $user->profile;
        }
    
        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'profile' => $imageName,
            // Hanya update password jika diisi
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
    
        // Redirect kembali ke index data staff dengan pesan sukses
        return redirect()->route('data-staff.index')->with('success', 'Data staff berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Temukan staff berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus staff
        $user->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('data-staff.index')->with('success', 'Staff deleted successfully.');
    }

}
