<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalDummySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 1. Pelanggans
        $pelanggans = [
            ['idPelanggan' => 'PEL001', 'nama' => 'Budi Santoso', 'created_at' => $now, 'updated_at' => $now],
            ['idPelanggan' => 'PEL002', 'nama' => 'Siti Aminah', 'created_at' => $now, 'updated_at' => $now],
            ['idPelanggan' => 'PEL003', 'nama' => 'Andi Wijaya', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('pelanggans')->insertOrIgnore($pelanggans);

        // 2. Karyawans
        $karyawans = [
            ['idKaryawan' => 'KAR001', 'nama' => 'Joko Anwar', 'noTelp' => '081234567890', 'Alamat' => 'Jl. Merdeka No.1', 'created_at' => $now, 'updated_at' => $now],
            ['idKaryawan' => 'KAR002', 'nama' => 'Rina Nose', 'noTelp' => '081298765432', 'Alamat' => 'Jl. Sudirman No.5', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('karyawans')->insertOrIgnore($karyawans);

        // 3. Merchant Brilinks
        $merchants = [
            [
                'id_merchant' => 'MER001', 'no_agen_bri' => '123456789', 'nama_toko' => 'Toko Maju Jaya',
                'pemilik' => 'Pak Budi', 'no_hp_terdaftar' => '08111222333', 'tipe_perangkat' => 'EDC',
                'saldo_limit' => 50000000, 'no_rekening_operasional' => '001122334455',
                'kantor_wilayah' => 'Jakarta Raya', 'target_bulanan' => 100, 'status_aktif' => 'Aktif',
                'alamat_toko' => 'Pasar Induk', 'created_at' => $now, 'updated_at' => $now
            ]
        ];
        DB::table('merchant_brilinks')->insertOrIgnore($merchants);

        // 4. Outlets
        $outlets = [
            [
                'id_outlet' => 'OUT001', 'nama_outlet' => 'Cabang Pusat', 'alamat' => 'Jl. Sudirman No. 1',
                'no_telp_outlet' => '021-123456', 'nama_manajer' => 'Pak Joko', 'jam_operasional' => '08:00 - 22:00',
                'created_at' => $now, 'updated_at' => $now
            ]
        ];
        DB::table('outlets')->insertOrIgnore($outlets);

        // 5. Pemasoks
        $pemasoks = [
            ['idPemasok' => 'PEM001', 'nama' => 'PT Indosat Ooredoo', 'noTelp' => '021-999999', 'kategoriProduk' => 'Provider', 'created_at' => $now, 'updated_at' => $now],
            ['idPemasok' => 'PEM002', 'nama' => 'Distributor Apple', 'noTelp' => '021-888888', 'kategoriProduk' => 'Handphone', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('pemasoks')->insertOrIgnore($pemasoks);

        // 6. Pengadaan Barangs
        $pengadaans = [
            [
                'idPengadaan' => 'PGD001', 'idPemasok' => 'PEM002', 'tanggal_pesan' => date('Y-m-d', strtotime('-5 days')),
                'tanggal_terima' => date('Y-m-d', strtotime('-2 days')), 'total_biaya' => 30000000,
                'created_at' => $now, 'updated_at' => $now
            ]
        ];
        DB::table('pengadaan_barangs')->insertOrIgnore($pengadaans);

        // 7. Transaksis
        $transaksis = [
            [
                'idTransaksi' => 'TRX001', 'tanggal' => date('Y-m-d'), 'id_outlet' => 'OUT001',
                'idPelanggan' => 'PEL001', 'idKaryawan' => 'KAR001', 'total' => 16500000,
                'metodeBayar' => 'Transfer Bank', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'idTransaksi' => 'TRX002', 'tanggal' => date('Y-m-d'), 'id_outlet' => 'OUT001',
                'idPelanggan' => 'PEL002', 'idKaryawan' => 'KAR002', 'total' => 45000,
                'metodeBayar' => 'Tunai', 'created_at' => $now, 'updated_at' => $now
            ]
        ];
        DB::table('transaksis')->insertOrIgnore($transaksis);

        // 8. Detail Pengadaans
        $detail_pengadaans = [
            [
                'idPengadaan' => 'PGD001', 'idProduk' => 'PRD001', 'jumlah_pesan' => 2,
                'total' => 30000000, 'created_at' => $now, 'updated_at' => $now
            ]
        ];
        DB::table('detail_pengadaans')->insertOrIgnore($detail_pengadaans);

        // 9. Detail Transaksis
        $detail_transaksis = [
            [
                'idTransaksi' => 'TRX001', 'idProduk' => 'PRD001', 'id_merchant' => null,
                'harga_satuan' => 16500000, 'jumlah' => 1, 'total' => 16500000,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'idTransaksi' => 'TRX002', 'idProduk' => 'PRD003', 'id_merchant' => null,
                'harga_satuan' => 45000, 'jumlah' => 1, 'total' => 45000,
                'created_at' => $now, 'updated_at' => $now
            ]
        ];
        DB::table('detail_transaksis')->insertOrIgnore($detail_transaksis);
    }
}
