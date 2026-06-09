<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DeanCell') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=source-sans-pro:300,400,400i,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Source Sans Pro', sans-serif; }
        .bg-admin-blue { background-color: #3c8dbc; }
        .bg-admin-blue-dark { background-color: #367fa9; }
        .bg-admin-sidebar { background-color: #222d32; }
        .bg-admin-sidebar-hover { background-color: #1e282c; }
        .text-admin-sidebar { color: #b8c7ce; }
        .bg-admin-body { background-color: #ecf0f5; }
        .border-admin-blue { border-top-color: #3c8dbc; }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-admin-body">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-64 bg-admin-sidebar text-admin-sidebar flex-shrink-0 flex flex-col hidden md:flex transition-all duration-300">
            <!-- Brand Logo -->
            <div class="h-14 flex items-center justify-center bg-admin-blue-dark text-white text-xl font-bold font-sans">
                <span class="font-light">Dean</span>Cell
            </div>

            <!-- User Panel -->
            <div class="flex items-center p-4 border-b border-gray-700">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-gray-500 flex items-center justify-center text-white">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin DeanCell' }}</p>
                    <a href="#" class="text-xs text-green-400"><i class="fas fa-circle text-xs mr-1"></i> Online</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="flex-1 overflow-y-auto py-4">
                <ul class="text-sm">
                    <li class="px-4 py-2 text-xs font-bold text-gray-500 uppercase tracking-wider">Main Navigation</li>
                    
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 hover:bg-admin-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('dashboard') ? 'bg-admin-sidebar-hover text-white border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-tachometer-alt w-6 text-center"></i>
                            <span class="ml-2">Dashboard</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('pelanggan.index') }}" class="flex items-center px-4 py-3 hover:bg-admin-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('pelanggan.*') ? 'bg-admin-sidebar-hover text-white border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-users w-6 text-center"></i>
                            <span class="ml-2">Pelanggan</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('karyawan.index') }}" class="flex items-center px-4 py-3 hover:bg-admin-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('karyawan.*') ? 'bg-admin-sidebar-hover text-white border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-user-tie w-6 text-center"></i>
                            <span class="ml-2">Karyawan</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('produk.index') }}" class="flex items-center px-4 py-3 hover:bg-admin-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('produk.*') ? 'bg-admin-sidebar-hover text-white border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-box w-6 text-center"></i>
                            <span class="ml-2">Produk</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('merchant_brilink.index') }}" class="flex items-center px-4 py-3 hover:bg-admin-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('merchant_brilink.*') ? 'bg-admin-sidebar-hover text-white border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-store w-6 text-center"></i>
                            <span class="ml-2">Merchant BRILink</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('outlet.index') }}" class="flex items-center px-4 py-3 hover:bg-admin-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('outlet.*') ? 'bg-admin-sidebar-hover text-white border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-building w-6 text-center"></i>
                            <span class="ml-2">Outlet</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('transaksi.index') }}" class="flex items-center px-4 py-3 hover:bg-admin-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('transaksi.*') ? 'bg-admin-sidebar-hover text-white border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-shopping-cart w-6 text-center"></i>
                            <span class="ml-2">Transaksi</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('detail_transaksi.index') }}" class="flex items-center px-4 py-3 hover:bg-admin-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('detail_transaksi.*') ? 'bg-admin-sidebar-hover text-white border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-list w-6 text-center"></i>
                            <span class="ml-2">Detail Transaksi</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('pemasok.index') }}" class="flex items-center px-4 py-3 hover:bg-admin-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('pemasok.*') ? 'bg-admin-sidebar-hover text-white border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-truck w-6 text-center"></i>
                            <span class="ml-2">Pemasok</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('pengadaan_barang.index') }}" class="flex items-center px-4 py-3 hover:bg-admin-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('pengadaan_barang.*') ? 'bg-admin-sidebar-hover text-white border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-clipboard-list w-6 text-center"></i>
                            <span class="ml-2">Pengadaan Barang</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('detail_pengadaan.index') }}" class="flex items-center px-4 py-3 hover:bg-admin-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('detail_pengadaan.*') ? 'bg-admin-sidebar-hover text-white border-l-4 border-blue-500' : '' }}">
                            <i class="fas fa-boxes w-6 text-center"></i>
                            <span class="ml-2">Detail Pengadaan</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="h-14 bg-admin-blue flex items-center justify-between px-4 text-white shadow z-10">
                <div class="flex items-center">
                    <button class="md:hidden text-white focus:outline-none mr-4">
                        <i class="fas fa-bars"></i>
                    </button>
                    <button class="hidden md:block text-white focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <div class="flex items-center">
                    <!-- Notifications -->
                    <button class="text-white mx-3 hover:text-gray-200 focus:outline-none relative">
                        <i class="far fa-bell"></i>
                        <span class="absolute top-0 right-0 -mt-1 -mr-1 px-1 py-0.5 bg-yellow-500 text-xs text-white rounded-full leading-none">10</span>
                    </button>
                    
                    <!-- Profile Dropdown -->
                    <div class="relative ml-3">
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="flex items-center text-sm font-medium text-white hover:text-gray-200 focus:outline-none transition duration-150 ease-in-out">
                                <span>{{ Auth::user()->name ?? 'Admin DeanCell' }}</span>
                                <i class="fas fa-sign-out-alt ml-2 text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-admin-body">
                <!-- Content Header -->
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-2xl font-normal text-gray-800">
                        @yield('header_title', 'Dashboard')
                        <small class="text-sm text-gray-500 ml-2 font-light">@yield('header_subtitle', 'Control panel')</small>
                    </h1>
                    <ol class="flex text-sm text-gray-600 bg-transparent rounded">
                        <li><a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800"><i class="fas fa-home mr-1"></i> Home</a></li>
                        <li class="mx-2">/</li>
                        <li class="text-gray-500">@yield('header_title', 'Dashboard')</li>
                    </ol>
                </div>

                <!-- Main Content Area -->
                <div class="w-full">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
