<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // dd($request);
        // $request->validate([
        //     'email' => 'required',
        //     'password'=> 'required' 
        //  ], [
        //     'email.required' => 'Kolom Email tidak boleh kosong.',
        //     'password.required' => 'Kolom Password tidak boleh kosong.',
        // ]);


        // dd($request->password);
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->role === 'Admin' || $user->role === 'Staff Proyek' || $user->role === 'Staff Gudang' || $user->role === 'Manager') {
                return redirect('/dashboard');
            } else {
                return redirect('/')->with('wrong', 'Role tidak Ditemukan !');
            }
        } else {
            return redirect('/')->with('wrong', 'Email dan password tidak tersedia');
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'Admin' || $user->role === 'Staff Proyek' || $user->role === 'Staff Gudang' || $user->role === 'Manager') {
                Auth::logout();
            }
        }
        return redirect('/');
    }

    public function dashboard(Request $request)
    {
        $karyawan = User::all()->count();
        $material = Product::all()->count();
        $sales = Sales::all()->count();

        return view('pages.dashboard', compact('karyawan', 'material', 'sales'));
    }
}
