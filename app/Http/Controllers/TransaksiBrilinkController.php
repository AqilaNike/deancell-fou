<?php

namespace App\Http\Controllers;

use App\Models\TransaksiBrilink;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiBrilinkController extends Controller
{
    /**
     * Tampilkan form ringkas untuk kasir
     */
    public function create()
    {
        return view('kasir.brilink.create');
    }

    /**
     * Simpan transaksi dan hitung fee admin otomatis
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_transaksi' => 'required|string|in:Tarik Tunai,Setor Tunai,Transfer',
            'nomor_referensi' => 'required|string',
            'nominal' => 'required|numeric|min:1',
        ]);

        $nominal = $request->input('nominal');
        $fee_admin = $nominal * 0.05; // 5% fee

        // Ambil karyawan pertama (seperti di KasirController)
        $karyawan = Karyawan::first();
        $idKaryawan = $karyawan ? $karyawan->idKaryawan : 'k11';

        TransaksiBrilink::create([
            'id_karyawan' => $idKaryawan,
            'jenis_transaksi' => $request->input('jenis_transaksi'),
            'nomor_referensi' => $request->input('nomor_referensi'),
            'nominal' => $nominal,
            'fee_admin' => $fee_admin,
            'tanggal' => now(),
        ]);

        // Simpan juga ke tabel transaksis
        $pelanggan = \App\Models\Pelanggan::first();
        $outlet = \App\Models\Outlet::first();
        $idTransaksi = 'TR' . rand(1000, 9999);

        \App\Models\Transaksi::create([
            'idTransaksi' => $idTransaksi,
            'tanggal' => now(),
            'total' => $nominal + $fee_admin, // Total termasuk fee
            'metodeBayar' => 'BRILink - ' . $request->input('jenis_transaksi'),
            'idKaryawan' => $idKaryawan,
            'idPelanggan' => $pelanggan ? $pelanggan->idPelanggan : 'i20',
            'id_outlet' => $outlet ? $outlet->id_outlet : 'o899',
        ]);

        return redirect()->route('kasir.brilink.create')
            ->with('success', 'Transaksi BRILink berhasil disimpan! Fee Admin: Rp ' . number_format($fee_admin, 0, ',', '.'));
    }

    /**
     * Tampilkan laporan BRILink untuk Admin
     */
    public function laporan()
    {
        $today = Carbon::today();

        // Statistik Hari Ini
        $totalTransaksiHariIni = TransaksiBrilink::whereDate('tanggal', $today)->count();
        $totalNominalHariIni = TransaksiBrilink::whereDate('tanggal', $today)->sum('nominal');
        $totalFeeHariIni = TransaksiBrilink::whereDate('tanggal', $today)->sum('fee_admin');

        // Statistik Bulan Ini
        $totalTransaksiBulanIni = TransaksiBrilink::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)->count();
        $totalNominalBulanIni = TransaksiBrilink::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)->sum('nominal');
        $totalFeeBulanIni = TransaksiBrilink::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)->sum('fee_admin');

        // Daftar Transaksi Terbaru
        $transaksis = TransaksiBrilink::with('karyawan')->orderBy('tanggal', 'desc')->paginate(20);

        return view('admin.brilink.laporan', compact(
            'totalTransaksiHariIni', 'totalNominalHariIni', 'totalFeeHariIni',
            'totalTransaksiBulanIni', 'totalNominalBulanIni', 'totalFeeBulanIni',
            'transaksis'
        ));
    }
}
