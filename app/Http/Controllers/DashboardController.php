<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Pelanggan;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $totalPelanggan = Pelanggan::count();
        $totalTransaksi = Transaksi::count();
        $totalProduk = Produk::count();
        $totalPendapatan = Transaksi::sum('total');

        // Data for Chart.js (Sales grouped by Date)
        $salesData = Transaksi::selectRaw('DATE(tanggal) as date, SUM(total) as daily_total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->limit(7) // Last 7 days with sales
            ->get();
            
        $chartDates = $salesData->pluck('date')->toArray();
        $chartTotals = $salesData->pluck('daily_total')->toArray();

        return view('admin.dashboard', compact(
            'totalPelanggan', 
            'totalTransaksi', 
            'totalProduk', 
            'totalPendapatan',
            'chartDates',
            'chartTotals'
        ));
    }
}
