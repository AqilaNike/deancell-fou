<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $totalPelanggan = Pelanggan::count();
        $totalTransaksi = Transaksi::count();
        $totalProduk = Produk::count();
        $totalPendapatan = Transaksi::sum('total');

        // Data for Chart.js - Actual last 7 days (including days with 0 sales)
        $chartDates = [];
        $chartTotals = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartDates[] = $date->format('d M');
            $chartTotals[] = (int) Transaksi::whereDate('tanggal', $date)->sum('total');
        }

        // Monthly sales data for the last 6 months (for doughnut chart)
        $monthlySalesLabels = [];
        $monthlySalesData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::today()->subMonths($i);
            $monthlySalesLabels[] = $month->translatedFormat('M Y');
            $monthlySalesData[] = (int) Transaksi::whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->sum('total');
        }

        // Top 5 selling products
        $topProducts = \App\Models\DetailTransaksi::selectRaw('idProduk, SUM(jumlah) as total_qty')
            ->groupBy('idProduk')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $produk = Produk::find($item->idProduk);
                return [
                    'name' => $produk ? $produk->namaProduk : $item->idProduk,
                    'qty' => $item->total_qty,
                ];
            });

        $topProductLabels = $topProducts->pluck('name')->toArray();
        $topProductData = $topProducts->pluck('qty')->toArray();

        return view('admin.dashboard', compact(
            'totalPelanggan', 
            'totalTransaksi', 
            'totalProduk', 
            'totalPendapatan',
            'chartDates',
            'chartTotals',
            'monthlySalesLabels',
            'monthlySalesData',
            'topProductLabels',
            'topProductData'
        ));
    }
}
