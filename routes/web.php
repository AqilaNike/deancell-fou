<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\MerchantBrilinkController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PengadaanBarangController;
use App\Http\Controllers\DetailPengadaanController;

Route::get('/', function () {
    // Redirect to a dashboard or one of the lists
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard'); // We will create this or use existing
})->name('dashboard');

// AdminLTE DeanCell Resource Routes
Route::resource('pelanggan', PelangganController::class);
Route::resource('karyawan', KaryawanController::class);
Route::resource('produk', ProdukController::class);
Route::resource('merchant_brilink', MerchantBrilinkController::class);
Route::resource('outlet', OutletController::class);
Route::resource('transaksi', TransaksiController::class);
Route::resource('detail_transaksi', DetailTransaksiController::class);
Route::resource('pemasok', PemasokController::class);
Route::resource('pengadaan_barang', PengadaanBarangController::class);
Route::resource('detail_pengadaan', DetailPengadaanController::class);

// Dummy auth routes for UI since Breeze is not actually installed
Route::post('/logout', function () {
    // Auth::logout();
    return redirect('/');
})->name('logout');
