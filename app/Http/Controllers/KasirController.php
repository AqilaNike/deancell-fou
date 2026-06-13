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

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Ambil data pertama sebagai default karena tidak boleh null
            $karyawan = \App\Models\Karyawan::first();
            $pelanggan = \App\Models\Pelanggan::first();
            $outlet = \App\Models\Outlet::first();

            $idTransaksi = 'TR' . rand(1000, 9999);

            // Simpan ke tabel transaksis
            $transaksi = Transaksi::create([
                'idTransaksi' => $idTransaksi,
                'tanggal' => now(),
                'total' => $total,
                'metodeBayar' => $request->input('payment_method', 'Cash'),
                'idKaryawan' => $karyawan ? $karyawan->idKaryawan : 'k11', 
                'idPelanggan' => $pelanggan ? $pelanggan->idPelanggan : 'i20', 
                'id_outlet' => $outlet ? $outlet->id_outlet : 'o899', 
            ]);

            // Simpan ke detail transaksi dan potong stok
            foreach ($cartData as $idProduk => $item) {
                \App\Models\DetailTransaksi::create([
                    'idTransaksi' => $idTransaksi,
                    'idProduk' => $idProduk,
                    'id_merchant' => null,
                    'harga_satuan' => $item['price'],
                    'jumlah' => $item['qty'],
                    'total' => $item['price'] * $item['qty'],
                ]);

                // Kurangi stok produk
                $produk = Produk::where('idProduk', $idProduk)->first();
                if ($produk) {
                    $produk->decrement('stok', $item['qty']);
                }
            }

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->back()->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollback();
            return redirect()->back()->withErrors(['Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
