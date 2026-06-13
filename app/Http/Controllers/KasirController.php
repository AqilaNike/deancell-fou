<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use Carbon\Carbon;

class KasirController extends Controller
{
    public function dashboard()
    {
        // Kasir dashboard logic (Sales today, this week, this month)
        $today = Carbon::today();
        
        $salesToday = Transaksi::whereDate('tanggal', $today)->sum('total');
        $salesWeek = Transaksi::whereBetween('tanggal', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()])->sum('total');
        $salesMonth = Transaksi::whereMonth('tanggal', $today->month)->whereYear('tanggal', $today->year)->sum('total');

        // Data for Chart.js
        $chartData = [$salesToday, $salesWeek, $salesMonth];

        return view('kasir.dashboard', compact('salesToday', 'salesWeek', 'salesMonth', 'chartData'));
    }

    public function pos()
    {
        $products = Produk::where('stok', '>', 0)->get();
        return view('kasir.pos', compact('products'));
    }

    public function checkout(Request $request)
    {
        $cartData = json_decode($request->input('cart_data'), true);
        $total = $request->input('total');

        if(empty($cartData)) {
            return redirect()->back()->withErrors(['Keranjang kosong!']);
        }

        // Simpan ke tabel transaksis
        $transaksi = Transaksi::create([
            'idTransaksi' => 'TR' . rand(1000, 9999),
            'tanggal' => now(),
            'total' => $total,
            'metodeBayar' => 'Cash',
            'idKaryawan' => null, 
            'idPelanggan' => null, 
            'id_outlet' => null, 
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil disimpan!');
    }
}
