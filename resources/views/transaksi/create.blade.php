@extends('layouts.admin')

@section('header_title', 'Tambah Transaksi')

@section('content')
<div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-500 max-w-3xl">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-800">Form Tambah Transaksi</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            
                <div class="mb-4">
                    <label for="idTransaksi" class="block text-sm font-medium text-gray-700 mb-1">IdTransaksi</label>
                    <input type="text" name="idTransaksi" id="idTransaksi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('idTransaksi') }}" required>
                    @error('idTransaksi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="id_outlet" class="block text-sm font-medium text-gray-700 mb-1">Id outlet</label>
                    <input type="text" name="id_outlet" id="id_outlet" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('id_outlet') }}" required>
                    @error('id_outlet')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="idPelanggan" class="block text-sm font-medium text-gray-700 mb-1">IdPelanggan</label>
                    <input type="text" name="idPelanggan" id="idPelanggan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('idPelanggan') }}" required>
                    @error('idPelanggan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="idKaryawan" class="block text-sm font-medium text-gray-700 mb-1">IdKaryawan</label>
                    <input type="text" name="idKaryawan" id="idKaryawan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('idKaryawan') }}" required>
                    @error('idKaryawan')
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
                <div class="mb-4">
                    <label for="metodeBayar" class="block text-sm font-medium text-gray-700 mb-1">MetodeBayar</label>
                    <input type="text" name="metodeBayar" id="metodeBayar" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('metodeBayar') }}" required>
                    @error('metodeBayar')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('transaksi.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection