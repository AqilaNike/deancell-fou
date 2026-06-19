<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi - {{ $transaksi->idTransaksi }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
        }
        @media print {
            body { background-color: white; }
            .no-print { display: none !important; }
            .receipt-container { box-shadow: none !important; max-width: 100% !important; border: none !important; }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen py-10 font-sans text-gray-800">

    <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-md receipt-container border border-gray-100">
        
        <!-- Header -->
        <div class="text-center border-b-2 border-dashed border-gray-300 pb-6 mb-6">
            <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4 text-green-500 animate-bounce no-print">
                <i class="fas fa-check-circle text-3xl"></i>
            </div>
            <h1 class="text-2xl font-black text-gray-900 mb-1 no-print">PESANAN BERHASIL</h1>
            <h2 class="text-xl font-bold text-gray-800 tracking-wider">DEANCELL</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $transaksi->outlet->alamat ?? 'Jl. Merdeka No. 1, Jakarta' }}</p>
            <p class="text-sm text-gray-500">{{ $transaksi->outlet->no_telp_outlet ?? '021-12345678' }}</p>
        </div>

        <!-- Info Transaksi -->
        <div class="text-sm text-gray-600 mb-6 space-y-1">
            <div class="flex justify-between">
                <span>No. Transaksi:</span>
                <span class="font-bold text-gray-800">{{ $transaksi->idTransaksi }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal:</span>
                <span class="font-medium">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y, H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kasir:</span>
                <span class="font-medium">{{ $transaksi->karyawan->nama ?? 'Sistem' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Metode:</span>
                <span class="font-medium">{{ $transaksi->metodeBayar }}</span>
            </div>
        </div>

        <!-- Detail Barang -->
        <div class="border-t-2 border-dashed border-gray-300 pt-4 mb-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-gray-500 text-left border-b border-gray-100">
                        <th class="pb-2 font-medium">Item</th>
                        <th class="pb-2 text-center font-medium">Qty</th>
                        <th class="pb-2 text-right font-medium">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="align-top">
                    @foreach($transaksi->detailTransaksis as $detail)
                    <tr class="border-b border-gray-50 last:border-0">
                        <td class="py-3 text-gray-800 pr-2">
                            <div class="font-semibold line-clamp-2">{{ $detail->produk->namaProduk ?? 'Produk Tidak Ditemukan' }}</div>
                            <div class="text-xs text-gray-500">@ Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</div>
                        </td>
                        <td class="py-3 text-center text-gray-800 font-medium">{{ $detail->jumlah }}</td>
                        <td class="py-3 text-right text-gray-800 font-bold">Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="border-t-2 border-dashed border-gray-300 pt-4 mb-8">
            <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-gray-800">TOTAL</span>
                <span class="text-xl font-black text-blue-600">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-400 mt-8 mb-6">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
        </div>

        <!-- Action Buttons (No Print) -->
        <div class="flex gap-3 no-print mt-8">
            <a href="{{ route('kasir.pos') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-xl text-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button onclick="window.print()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl text-center transition-colors shadow-md">
                <i class="fas fa-print mr-2"></i> Cetak Nota
            </button>
        </div>
    </div>

</body>
</html>
