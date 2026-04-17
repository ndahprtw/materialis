<?php

use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelacakanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StaffController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::group(['middleware' => 'cekrole:Admin,Karyawan,Kurir'], function() {
    Route::resource('/pelacakan', PelacakanController::class)->names('pelacakan');
    Route::get('/ditolak/{id}', [PelacakanController::class, 'update2']);
});

Route::group(['middleware' => 'cekrole:Admin,Karyawan'], function() {
    Route::get('/dashboard', [LoginController::class, 'dashboard']);
    Route::resource('/data-staff', StaffController::class)->names('data-staff');
    Route::resource('/data-pelanggan', PelangganController::class)->names('pelanggan');
    Route::resource('/data-product', ProductController::class)->names('data-product');
    Route::resource('/data-sales', SalesController::class)->names('data-sales');
    Route::resource('/inventory', InventoryController::class)->names('inventory');
    Route::get('/laporan', [InventoryController::class, 'laporan']);
    Route::get('/unduh-laporan/{tahun}/{bulan}', [InventoryController::class, 'unduh_laporan']);
    Route::get('/diantar/{id}', [PelacakanController::class, 'update1']);
});
Route::group(['middleware' => 'cekrole:Admin'], function() {
    Route::resource('/data-staff', StaffController::class)->names('data-staff');
});


