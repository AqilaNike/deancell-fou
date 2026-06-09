@extends('layouts.admin')

@section('header_title', 'Tambah DetailTransaksi')

@section('content')
<div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-500 max-w-3xl">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-800">Form Tambah DetailTransaksi</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('detail_transaksi.store') }}" method="POST">
            @csrf
            
                <div class="mb-4">
                    <label for="idTransaksi" class="block text-sm font-medium text-gray-700 mb-1">IdTransaksi</label>
                    <input type="text" name="idTransaksi" id="idTransaksi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('idTransaksi') }}" required>
                    @error('idTransaksi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="idProduk" class="block text-sm font-medium text-gray-700 mb-1">IdProduk</label>
                    <input type="text" name="idProduk" id="idProduk" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('idProduk') }}" required>
                    @error('idProduk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="id_merchant" class="block text-sm font-medium text-gray-700 mb-1">Id merchant</label>
                    <input type="text" name="id_merchant" id="id_merchant" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('id_merchant') }}" required>
                    @error('id_merchant')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="harga_satuan" class="block text-sm font-medium text-gray-700 mb-1">Harga satuan</label>
                    <input type="text" name="harga_satuan" id="harga_satuan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('harga_satuan') }}" required>
                    @error('harga_satuan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="text" name="jumlah" id="jumlah" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('jumlah') }}" required>
                    @error('jumlah')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="total" class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                    <input type="text" name="total" id="total" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('total') }}" required>
                    @error('total')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('detail_transaksi.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection