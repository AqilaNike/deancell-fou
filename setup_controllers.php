<?php

$controllersDir = __DIR__ . '/app/Http/Controllers/';

$entities = [
    'Pelanggan' => 'pelanggans',
    'Karyawan' => 'karyawans',
    'Produk' => 'produks',
    'MerchantBrilink' => 'merchant_brilinks',
    'Outlet' => 'outlets',
    'Transaksi' => 'transaksis',
    'DetailTransaksi' => 'detail_transaksis',
    'Pemasok' => 'pemasoks',
    'PengadaanBarang' => 'pengadaan_barangs',
    'DetailPengadaan' => 'detail_pengadaans',
];

foreach ($entities as $model => $table) {
    $controllerName = $model . 'Controller';
    $viewPath = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $model));
    $routeName = $viewPath;
    
    // For primary key
    $primaryKey = 'id';
    if ($model == 'Pelanggan') $primaryKey = 'idPelanggan';
    if ($model == 'Karyawan') $primaryKey = 'idKaryawan';
    if ($model == 'Produk') $primaryKey = 'idProduk';
    if ($model == 'MerchantBrilink') $primaryKey = 'id_merchant';
    if ($model == 'Outlet') $primaryKey = 'id_outlet';
    if ($model == 'Transaksi') $primaryKey = 'idTransaksi';
    if ($model == 'Pemasok') $primaryKey = 'idPemasok';
    if ($model == 'PengadaanBarang') $primaryKey = 'idPengadaan';
    // For detail tables they don't have single primary keys in standard way but we will skip complex route model binding for them in this simple generation
    
    $content = <<<PHP
<?php

namespace App\Http\Controllers;

use App\Models\\$model;
use Illuminate\Http\Request;

class {$controllerName} extends Controller
{
    public function index()
    {
        \$data = $model::all();
        return view('{$viewPath}.index', compact('data'));
    }

    public function create()
    {
        return view('{$viewPath}.create');
    }

    public function store(Request \$request)
    {
        \$validated = \$request->validate([
            // Add validation rules here
            '{$primaryKey}' => 'required|string|max:10|unique:{$table},{$primaryKey}'
        ]);

        $model::create(\$request->all());

        return redirect()->route('{$routeName}.index')
            ->with('success', '{$model} created successfully.');
    }

    public function show(\$id)
    {
        \$item = $model::findOrFail(\$id);
        return view('{$viewPath}.show', compact('item'));
    }

    public function edit(\$id)
    {
        \$item = $model::findOrFail(\$id);
        return view('{$viewPath}.edit', compact('item'));
    }

    public function update(Request \$request, \$id)
    {
        \$item = $model::findOrFail(\$id);
        \$item->update(\$request->all());

        return redirect()->route('{$routeName}.index')
            ->with('success', '{$model} updated successfully.');
    }

    public function destroy(\$id)
    {
        \$item = $model::findOrFail(\$id);
        \$item->delete();

        return redirect()->route('{$routeName}.index')
            ->with('success', '{$model} deleted successfully.');
    }
}
PHP;

    file_put_contents($controllersDir . $controllerName . '.php', $content);
    echo "Updated Controller: \$controllerName\n";
}

// Create a basic dashboard view if not exists
$viewsDir = __DIR__ . '/resources/views/';
if (!file_exists($viewsDir . 'dashboard.blade.php')) {
    $dashboardContent = <<<HTML
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
HTML;
    file_put_contents($viewsDir . 'dashboard.blade.php', $dashboardContent);
    echo "Created dashboard view\n";
}
