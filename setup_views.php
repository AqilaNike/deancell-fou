<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$viewsDir = __DIR__ . '/resources/views/';

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
    $viewPath = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $model));
    $routeName = $viewPath;
    $entityDir = $viewsDir . $viewPath;
    
    if (!is_dir($entityDir)) {
        mkdir($entityDir, 0755, true);
    }
    
    $columns = Schema::getColumnListing($table);
    // filter out timestamps
    $columns = array_filter($columns, function($c) { return !in_array($c, ['created_at', 'updated_at']); });
    
    $primaryKey = $columns[0] ?? 'id'; // naive assumption the first is PK
    
    // INDEX VIEW
    $ths = "";
    $tds = "";
    foreach ($columns as $col) {
        $ths .= "                                <th class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">" . ucfirst(str_replace('_', ' ', $col)) . "</th>\n";
        $tds .= "                                <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-900\">{{ \$item->" . $col . " }}</td>\n";
    }
    
    $indexContent = <<<HTML
@extends('layouts.admin')

@section('header_title', 'Data {$model}')

@section('content')
<div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-500">
    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-800">Daftar {$model}</h3>
        <a href="{{ route('{$routeName}.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition-colors">
            <i class="fas fa-plus mr-1"></i> Tambah Data
        </a>
    </div>
    
    <div class="p-0 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
{$ths}
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse(\$data as \$item)
                    <tr class="hover:bg-gray-50 transition-colors">
{$tds}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('{$routeName}.edit', \$item->{$primaryKey}) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('{$routeName}.destroy', \$item->{$primaryKey}) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
HTML;
    file_put_contents($entityDir . '/index.blade.php', $indexContent);
    
    // CREATE VIEW
    $formGroups = "";
    foreach ($columns as $col) {
        $label = ucfirst(str_replace('_', ' ', $col));
        $formGroups .= <<<HTML
                <div class="mb-4">
                    <label for="{$col}" class="block text-sm font-medium text-gray-700 mb-1">{$label}</label>
                    <input type="text" name="{$col}" id="{$col}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('{$col}') }}" required>
                    @error('{$col}')
                        <p class="text-red-500 text-xs mt-1">{{ \$message }}</p>
                    @enderror
                </div>\n
HTML;
    }

    $createContent = <<<HTML
@extends('layouts.admin')

@section('header_title', 'Tambah {$model}')

@section('content')
<div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-500 max-w-3xl">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-800">Form Tambah {$model}</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('{$routeName}.store') }}" method="POST">
            @csrf
            
{$formGroups}
            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('{$routeName}.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
HTML;
    file_put_contents($entityDir . '/create.blade.php', $createContent);

    // EDIT VIEW
    $editFormGroups = "";
    foreach ($columns as $col) {
        $label = ucfirst(str_replace('_', ' ', $col));
        $isReadonly = ($col == $primaryKey) ? 'readonly class="w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"' : 'class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"';
        $editFormGroups .= <<<HTML
                <div class="mb-4">
                    <label for="{$col}" class="block text-sm font-medium text-gray-700 mb-1">{$label}</label>
                    <input type="text" name="{$col}" id="{$col}" {$isReadonly} value="{{ old('{$col}', \$item->{$col}) }}" required>
                    @error('{$col}')
                        <p class="text-red-500 text-xs mt-1">{{ \$message }}</p>
                    @enderror
                </div>\n
HTML;
    }

    $editContent = <<<HTML
@extends('layouts.admin')

@section('header_title', 'Edit {$model}')

@section('content')
<div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-500 max-w-3xl">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-800">Form Edit {$model}</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('{$routeName}.update', \$item->{$primaryKey}) }}" method="POST">
            @csrf
            @method('PUT')
            
{$editFormGroups}
            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('{$routeName}.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
HTML;
    file_put_contents($entityDir . '/edit.blade.php', $editContent);
    echo "Created views for {$model}\n";
}

echo "All views generated successfully.\n";
