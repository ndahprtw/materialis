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


        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->role === 'admin' || $user->role === 'staff proyek' || $user->role === 'staff gudang' || $user->role === 'manager') {
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

            if ($user->role === 'admin' || $user->role === 'staff proyek' || $user->role === 'staff gudang' || $user->role === 'manager') {
                Auth::logout();
            }
        }
        return redirect('/');
    }

    public function dashboard(Request $request)
    {
        $karyawan = User::where('role', 'Karyawan')->count();

        return view('pages.dashboard', compact('karyawan'));
    }
}
