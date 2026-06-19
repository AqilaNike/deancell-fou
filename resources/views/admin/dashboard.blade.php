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

{{-- Grafik Penjualan 7 Hari Terakhir (Area Chart) --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Grafik Penjualan 7 Hari Terakhir</h3>
                <p class="text-sm text-gray-400 mt-1">Tren pendapatan harian</p>
            </div>
            <a href="{{ route('transaksi.index') }}" class="text-brand-600 text-sm font-medium hover:text-brand-700 flex items-center gap-1">
                Lihat Detail <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="w-full" style="height: 320px;">
            <canvas id="adminChart"></canvas>
        </div>
    </div>
    
    {{-- Doughnut Chart: Penjualan per Bulan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-800">Penjualan Bulanan</h3>
            <p class="text-sm text-gray-400 mt-1">6 bulan terakhir</p>
        </div>
        <div class="w-full flex justify-center" style="height: 250px;">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
</div>

{{-- Grafik Produk Terlaris --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Top 5 Produk Terlaris</h3>
                <p class="text-sm text-gray-400 mt-1">Berdasarkan jumlah terjual</p>
            </div>
            <a href="{{ route('produk.index') }}" class="text-brand-600 text-sm font-medium hover:text-brand-700 flex items-center gap-1">
                Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="w-full" style="height: 280px;">
            <canvas id="topProductChart"></canvas>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center items-center text-center">
        <div class="w-20 h-20 bg-brand-50 rounded-full flex items-center justify-center text-brand-500 mb-4">
            <i class="fas fa-chart-pie text-3xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Deanova ERP Analytics</h3>
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
        // ========== GRAFIK PENJUALAN 7 HARI TERAKHIR (Area Chart) ==========
        const ctx = document.getElementById('adminChart').getContext('2d');
        const dates = @json($chartDates);
        const totals = @json($chartTotals);
        
        // Create gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 320);
        gradient.addColorStop(0, 'rgba(20, 184, 166, 0.3)');
        gradient.addColorStop(0.5, 'rgba(20, 184, 166, 0.08)');
        gradient.addColorStop(1, 'rgba(20, 184, 166, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates.length > 0 ? dates : ['Tidak ada data'],
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: totals.length > 0 ? totals : [0],
                    borderColor: '#14b8a6',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#14b8a6',
                    pointBorderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#14b8a6',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#e2e8f0',
                        bodyColor: '#ffffff',
                        bodyFont: { size: 14, weight: 'bold' },
                        titleFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        border: { display: false },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.04)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11 },
                            padding: 8,
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                } else if (value >= 1000) {
                                    return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                                }
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        border: { display: false },
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11 },
                            padding: 8
                        }
                    }
                }
            }
        });

        // ========== DOUGHNUT CHART: Penjualan Bulanan ==========
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyLabels = @json($monthlySalesLabels);
        const monthlyData = @json($monthlySalesData);

        const doughnutColors = [
            '#14b8a6', '#6366f1', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'
        ];

        new Chart(monthlyCtx, {
            type: 'doughnut',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    data: monthlyData,
                    backgroundColor: doughnutColors,
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 12,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 11 },
                            color: '#64748b'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#e2e8f0',
                        bodyColor: '#ffffff',
                        bodyFont: { size: 13, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                return ' Rp ' + context.parsed.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // ========== BAR CHART: Top 5 Produk Terlaris ==========
        const topCtx = document.getElementById('topProductChart').getContext('2d');
        const topLabels = @json($topProductLabels);
        const topData = @json($topProductData);

        const barGradient = topCtx.createLinearGradient(0, 0, 0, 280);
        barGradient.addColorStop(0, 'rgba(99, 102, 241, 0.85)');
        barGradient.addColorStop(1, 'rgba(99, 102, 241, 0.35)');

        new Chart(topCtx, {
            type: 'bar',
            data: {
                labels: topLabels.length > 0 ? topLabels : ['Belum ada data'],
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: topData.length > 0 ? topData : [0],
                    backgroundColor: [
                        'rgba(20, 184, 166, 0.8)',
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                    ],
                    borderColor: [
                        '#14b8a6',
                        '#6366f1',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6',
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        bodyColor: '#ffffff',
                        bodyFont: { size: 13, weight: 'bold' },
                        titleFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.x + ' unit terjual';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        border: { display: false },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.04)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11 },
                            padding: 8
                        }
                    },
                    y: {
                        border: { display: false },
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#334155',
                            font: { size: 12, weight: '500' },
                            padding: 8
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
