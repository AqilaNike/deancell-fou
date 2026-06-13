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

    <!-- Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Penjualan Kasir</h3>
        <div class="w-full h-64">
            <canvas id="kasirChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('kasirChart').getContext('2d');
        const chartData = @json($chartData);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Hari Ini', 'Minggu Ini', 'Bulan Ini'],
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: chartData,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.5)',
                        'rgba(16, 185, 129, 0.5)',
                        'rgba(139, 92, 246, 0.5)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(139, 92, 246)'
                    ],
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
