<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeanCell - Kasir POS</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 h-screen flex flex-col overflow-hidden">
    <!-- Top Navigation -->
    <header class="bg-white shadow-sm border-b border-gray-200 py-3 px-6 flex justify-between items-center z-10">
        <div class="flex items-center space-x-4">
            <h1 class="text-2xl font-bold text-blue-600"><i class="fas fa-store mr-2"></i>DeanCell Kasir</h1>
            <nav class="hidden md:flex space-x-1">
                <a href="{{ route('kasir.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('kasir.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">Dashboard</a>
                <a href="{{ route('kasir.pos') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('kasir.pos') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">Point of Sale</a>
                <a href="{{ route('transaksi.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('transaksi.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">Riwayat Transaksi</a>
            </nav>
        </div>
        
        <div class="flex items-center space-x-4">
            <span class="text-sm font-medium text-gray-700"><i class="fas fa-user-circle mr-1"></i> {{ Auth::user()->name ?? 'Kasir' }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium bg-red-50 hover:bg-red-100 px-3 py-2 rounded transition-colors">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 flex overflow-hidden">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
