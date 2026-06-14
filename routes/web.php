<?php

use App\Http\Controllers\DetailPermintaanController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelacakanController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;
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

Route::group(['middleware' => 'cekrole:Admin,Staff Gudang,Staff Proyek,Manager'], function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard']);
    Route::get('/cetak-data', [InventoryController::class, 'cetak_data']);

    Route::get('/laporan', [InventoryController::class, 'laporan']);
    Route::get('/download-data', [InventoryController::class, 'download'])->name('inventory.download');
    Route::get('/unduh-laporan/{tahun}/{bulan}', [InventoryController::class, 'unduh_laporan']);
});

Route::group(['middleware' => 'cekrole:Admin,Staff Gudang,Manager'], function () {
    Route::resource('/inventory', InventoryController::class)->names('inventory');
});

Route::group(['middleware' => 'cekrole:Staff Proyek,Staff Gudang'], function () {
    Route::resource('/permintaan', PermintaanController::class)->names('permintaan');
    Route::resource('/detail-permintaan', DetailPermintaanController::class)->names('detail-permintaan');
});

Route::group(['middleware' => 'cekrole:Admin,Manager'], function () {
    Route::resource('/data-staff', StaffController::class)->names('data-staff');
    Route::resource('/data-product', ProductController::class)->names('data-product');
    Route::resource('/data-sales', SalesController::class)->names('data-sales');
});
