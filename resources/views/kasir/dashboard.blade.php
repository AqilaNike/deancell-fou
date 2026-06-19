@extends('layouts.kasir')

@section('content')
<div class="p-6 w-full overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Kasir</h2>
            <p class="text-gray-500">Ringkasan penjualan shift Anda</p>
        </div>
        <div>
            <a href="{{ route('kasir.pos') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition-all flex items-center">
                <i class="fas fa-cash-register mr-2"></i> Buka Mesin Kasir (POS)
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="bg-blue-100 p-4 rounded-lg text-blue-600 mr-4">
                <i class="fas fa-calendar-day text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Penjualan Hari Ini</p>
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($salesToday, 0, ',', '.') }}</h3>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="bg-green-100 p-4 rounded-lg text-green-600 mr-4">
                <i class="fas fa-calendar-week text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Penjualan Minggu Ini</p>
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($salesWeek, 0, ',', '.') }}</h3>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="bg-purple-100 p-4 rounded-lg text-purple-600 mr-4">
                <i class="fas fa-calendar-alt text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Penjualan Bulan Ini</p>
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($salesMonth, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Area Chart: 7 Hari Terakhir -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Grafik Penjualan 7 Hari Terakhir</h3>
                    <p class="text-sm text-gray-400 mt-1">Tren pendapatan harian</p>
                </div>
            </div>
            <div class="w-full" style="height: 280px;">
                <canvas id="kasirLineChart"></canvas>
            </div>
        </div>

        <!-- Bar Chart: Ringkasan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-800">Ringkasan Penjualan</h3>
                <p class="text-sm text-gray-400 mt-1">Hari ini, minggu ini, bulan ini</p>
            </div>
            <div class="w-full" style="height: 280px;">
                <canvas id="kasirBarChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========== LINE CHART: 7 Hari Terakhir ==========
        const lineCtx = document.getElementById('kasirLineChart').getContext('2d');
        const dates = @json($chartDates);
        const totals = @json($chartTotals);

        const gradient = lineCtx.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.25)');
        gradient.addColorStop(0.5, 'rgba(59, 130, 246, 0.06)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: dates.length > 0 ? dates : ['Tidak ada data'],
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: totals.length > 0 ? totals : [0],
                    borderColor: '#3b82f6',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#3b82f6',
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
                    legend: { display: false },
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
                        grid: { display: false },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11 },
                            padding: 8
                        }
                    }
                }
            }
        });

        // ========== BAR CHART: Ringkasan ==========
        const barCtx = document.getElementById('kasirBarChart').getContext('2d');
        const chartData = @json($chartData);

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Hari Ini', 'Minggu Ini', 'Bulan Ini'],
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: chartData,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.75)',
                        'rgba(16, 185, 129, 0.75)',
                        'rgba(139, 92, 246, 0.75)'
                    ],
                    borderColor: [
                        '#3b82f6',
                        '#10b981',
                        '#8b5cf6'
                    ],
                    borderWidth: 2,
                    borderRadius: 10,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        bodyColor: '#ffffff',
                        bodyFont: { size: 13, weight: 'bold' },
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
                        grid: { display: false },
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
