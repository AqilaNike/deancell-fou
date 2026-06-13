@extends('layouts.admin')

@section('header_title', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Box -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="bg-blue-50 w-14 h-14 rounded-xl flex items-center justify-center text-blue-600 mr-4">
            <i class="fas fa-users text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">Total Pelanggan</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalPelanggan }}</h3>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="bg-green-50 w-14 h-14 rounded-xl flex items-center justify-center text-green-600 mr-4">
            <i class="fas fa-shopping-cart text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">Total Transaksi</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalTransaksi }}</h3>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="bg-purple-50 w-14 h-14 rounded-xl flex items-center justify-center text-purple-600 mr-4">
            <i class="fas fa-box text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">Total Produk</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalProduk }}</h3>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="bg-emerald-50 w-14 h-14 rounded-xl flex items-center justify-center text-emerald-600 mr-4">
            <i class="fas fa-money-bill-wave text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800">Grafik Penjualan 7 Hari Terakhir</h3>
            <button class="text-brand-600 text-sm font-medium hover:text-brand-700">Lihat Detail</button>
        </div>
        <div class="w-full h-72">
            <canvas id="adminChart"></canvas>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center items-center text-center">
        <div class="w-20 h-20 bg-brand-50 rounded-full flex items-center justify-center text-brand-500 mb-4">
            <i class="fas fa-chart-pie text-3xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">DeanCell Analytics</h3>
        <p class="text-gray-500 text-sm mb-6">Pantau terus perkembangan penjualan dan stok produk Anda untuk memaksimalkan keuntungan bisnis.</p>
        <a href="{{ route('transaksi.index') }}" class="w-full py-2.5 px-4 bg-brand-50 hover:bg-brand-100 text-brand-700 font-medium rounded-xl transition-colors">
            Kelola Transaksi
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('adminChart').getContext('2d');
        const dates = @json($chartDates);
        const totals = @json($chartTotals);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates.length > 0 ? dates : ['Tidak ada data'],
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: totals.length > 0 ? totals : [0],
                    borderColor: '#14b8a6',
                    backgroundColor: 'rgba(20, 184, 166, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#14b8a6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
