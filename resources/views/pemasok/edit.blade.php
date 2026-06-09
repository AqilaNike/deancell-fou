@extends('layouts.admin')

@section('header_title', 'Edit Pemasok')

@section('content')
<div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-500 max-w-3xl">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-800">Form Edit Pemasok</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('pemasok.update', $item->idPemasok) }}" method="POST">
            @csrf
            @method('PUT')
            
                <div class="mb-4">
                    <label for="idPemasok" class="block text-sm font-medium text-gray-700 mb-1">IdPemasok</label>
                    <input type="text" name="idPemasok" id="idPemasok" readonly class="w-full rounded-md border-gray-300 bg-gray-100 shadow-sm" value="{{ old('idPemasok', $item->idPemasok) }}" required>
                    @error('idPemasok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="nama" id="nama" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('nama', $item->nama) }}" required>
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="noTelp" class="block text-sm font-medium text-gray-700 mb-1">NoTelp</label>
                    <input type="text" name="noTelp" id="noTelp" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('noTelp', $item->noTelp) }}" required>
                    @error('noTelp')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="kategoriProduk" class="block text-sm font-medium text-gray-700 mb-1">KategoriProduk</label>
                    <input type="text" name="kategoriProduk" id="kategoriProduk" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('kategoriProduk', $item->kategoriProduk) }}" required>
                    @error('kategoriProduk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('pemasok.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection