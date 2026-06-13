<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Import custom controllers
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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    
    // Redirect /dashboard based on role
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('kasir.dashboard');
    })->name('dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        
        Route::resource('pelanggan', PelangganController::class);
        Route::resource('karyawan', KaryawanController::class);
        Route::resource('produk', ProdukController::class);
        Route::resource('merchant_brilink', MerchantBrilinkController::class);
        Route::resource('outlet', OutletController::class);
        Route::resource('pemasok', PemasokController::class);
        Route::resource('pengadaan_barang', PengadaanBarangController::class);
        Route::resource('detail_pengadaan', DetailPengadaanController::class);
    });

    // Kasir Routes
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/kasir/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
        Route::get('/kasir/pos', [KasirController::class, 'pos'])->name('kasir.pos');
        Route::post('/kasir/pos/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');
    });

    // Shared Routes (Admin and Kasir can both manage transactions)
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('detail_transaksi', DetailTransaksiController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
