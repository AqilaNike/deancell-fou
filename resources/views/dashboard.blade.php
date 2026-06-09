@extends('layouts.admin')
@section('header_title', 'Dashboard')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Stat Box -->
    <div class="bg-blue-500 rounded-lg shadow-sm p-4 text-white flex items-center justify-between">
        <div>
            <h3 class="text-3xl font-bold">150</h3>
            <p class="text-blue-100">Pelanggan Baru</p>
        </div>
        <div class="text-4xl text-blue-200"><i class="fas fa-users"></i></div>
    </div>
    
    <div class="bg-green-500 rounded-lg shadow-sm p-4 text-white flex items-center justify-between">
        <div>
            <h3 class="text-3xl font-bold">53<sup class="text-xl">%</sup></h3>
            <p class="text-green-100">Transaksi</p>
        </div>
        <div class="text-4xl text-green-200"><i class="fas fa-shopping-cart"></i></div>
    </div>
    
    <div class="bg-yellow-500 rounded-lg shadow-sm p-4 text-white flex items-center justify-between">
        <div>
            <h3 class="text-3xl font-bold">44</h3>
            <p class="text-yellow-100">Outlet</p>
        </div>
        <div class="text-4xl text-yellow-200"><i class="fas fa-building"></i></div>
    </div>
    
    <div class="bg-red-500 rounded-lg shadow-sm p-4 text-white flex items-center justify-between">
        <div>
            <h3 class="text-3xl font-bold">65</h3>
            <p class="text-red-100">Produk Unik</p>
        </div>
        <div class="text-4xl text-red-200"><i class="fas fa-box"></i></div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-500">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-800">Welcome to DeanCell Dashboard</h3>
    </div>
    <div class="p-4">
        <p>Silakan gunakan menu navigasi di sebelah kiri untuk mengelola data master dan transaksi.</p>
    </div>
</div>
@endsection