<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Transaksi BRILink') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Hari Ini -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-teal-500">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Fee Hari Ini (5%)</div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">Rp {{ number_format($totalFeeHariIni, 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-600">
                            Dari {{ $totalTransaksiHariIni }} Transaksi<br>
                            Total Nominal: Rp {{ number_format($totalNominalHariIni, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Bulan Ini -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Fee Bulan Ini (5%)</div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">Rp {{ number_format($totalFeeBulanIni, 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-600">
                            Dari {{ $totalTransaksiBulanIni }} Transaksi<br>
                            Total Nominal: Rp {{ number_format($totalNominalBulanIni, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Riwayat Transaksi Terbaru</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Referensi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee (Keuntungan)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasir</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($transaksis as $t)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $t->tanggal->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $t->nomor_referensi }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $t->jenis_transaksi == 'Transfer' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $t->jenis_transaksi == 'Tarik Tunai' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $t->jenis_transaksi == 'Setor Tunai' ? 'bg-green-100 text-green-800' : '' }}
                                        ">
                                            {{ $t->jenis_transaksi }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($t->nominal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-teal-600 font-bold">
                                        Rp {{ number_format($t->fee_admin, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $t->karyawan->namaKaryawan ?? 'Unknown' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Belum ada transaksi BRILink.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $transaksis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
