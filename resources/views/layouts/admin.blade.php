<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deanova ERP - Management System</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#14b8a6',
                            600: '#0d9488',
                            900: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar for modern look */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent; 
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex h-screen overflow-hidden antialiased">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col transition-all duration-300 z-20">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <div class="flex items-center gap-3 text-brand-600">
                <div class="bg-brand-100 p-2 rounded-lg">
                    <i class="fas fa-layer-group text-xl"></i>
                </div>
                <span class="text-xl font-bold tracking-tight">Deanova <span class="text-gray-400 font-light">ERP</span></span>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">Menu Utama</p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fas fa-home w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-brand-500' : 'text-gray-400' }}"></i>
                Dashboard
            </a>

            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Master Data</p>
            
            <a href="{{ route('produk.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('produk.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fas fa-box w-5 text-center {{ request()->routeIs('produk.*') ? 'text-brand-500' : 'text-gray-400' }}"></i>
                Data Produk
            </a>
            <a href="{{ route('pelanggan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('pelanggan.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fas fa-users w-5 text-center {{ request()->routeIs('pelanggan.*') ? 'text-brand-500' : 'text-gray-400' }}"></i>
                Pelanggan
            </a>
            <a href="{{ route('karyawan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('karyawan.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fas fa-id-badge w-5 text-center {{ request()->routeIs('karyawan.*') ? 'text-brand-500' : 'text-gray-400' }}"></i>
                Karyawan
            </a>
            <a href="{{ route('merchant_brilink.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('merchant_brilink.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fas fa-store-alt w-5 text-center {{ request()->routeIs('merchant_brilink.*') ? 'text-brand-500' : 'text-gray-400' }}"></i>
                Merchant BRILink
            </a>
            <a href="{{ route('outlet.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('outlet.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fas fa-building w-5 text-center {{ request()->routeIs('outlet.*') ? 'text-brand-500' : 'text-gray-400' }}"></i>
                Outlet
            </a>
            <a href="{{ route('pemasok.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('pemasok.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fas fa-truck w-5 text-center {{ request()->routeIs('pemasok.*') ? 'text-brand-500' : 'text-gray-400' }}"></i>
                Pemasok
            </a>

            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Transaksi</p>
            
            <a href="{{ route('transaksi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('transaksi.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fas fa-shopping-cart w-5 text-center {{ request()->routeIs('transaksi.*') ? 'text-brand-500' : 'text-gray-400' }}"></i>
                Penjualan (Kasir)
            </a>
            <a href="{{ route('pengadaan_barang.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('pengadaan_barang.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fas fa-boxes w-5 text-center {{ request()->routeIs('pengadaan_barang.*') ? 'text-brand-500' : 'text-gray-400' }}"></i>
                Pengadaan Barang
            </a>
            <a href="{{ route('detail_transaksi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('detail_transaksi.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fas fa-list-alt w-5 text-center {{ request()->routeIs('detail_transaksi.*') ? 'text-brand-500' : 'text-gray-400' }}"></i>
                Detail Transaksi
            </a>
            <a href="{{ route('detail_pengadaan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('detail_pengadaan.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fas fa-clipboard-list w-5 text-center {{ request()->routeIs('detail_pengadaan.*') ? 'text-brand-500' : 'text-gray-400' }}"></i>
                Detail Pengadaan
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 bg-gray-50/50">
        <!-- Topbar -->
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-10">
            <div>
                <h2 class="text-xl font-bold text-gray-800 tracking-tight">@yield('header_title', 'Dashboard')</h2>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 bg-gray-50 py-1.5 px-3 rounded-full border border-gray-200">
                    <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 font-bold">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="text-sm">
                        <p class="font-medium text-gray-700 leading-none">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-xs text-gray-500 mt-1 capitalize">{{ Auth::user()->role ?? 'Admin' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-10 h-10 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-red-600 hover:bg-red-50 hover:border-red-100 transition-colors flex items-center justify-center" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="bg-teal-50 border border-teal-200 text-teal-800 px-4 py-3 rounded-lg relative mb-6 shadow-sm flex items-center gap-3" role="alert">
                    <i class="fas fa-check-circle text-teal-500 text-xl"></i>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg relative mb-6 shadow-sm flex items-start gap-3" role="alert">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5"></i>
                    <div>
                        <strong class="font-bold">Oops! Ada kesalahan.</strong>
                        <ul class="list-disc mt-1 ml-4 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
