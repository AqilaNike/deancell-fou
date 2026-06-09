@extends('layouts.admin')

@section('header_title', 'Tambah PengadaanBarang')

@section('content')
<div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-500 max-w-3xl">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-800">Form Tambah PengadaanBarang</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('pengadaan_barang.store') }}" method="POST">
            @csrf
            
                <div class="mb-4">
                    <label for="idPengadaan" class="block text-sm font-medium text-gray-700 mb-1">IdPengadaan</label>
                    <input type="text" name="idPengadaan" id="idPengadaan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('idPengadaan') }}" required>
                    @error('idPengadaan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="idPemasok" class="block text-sm font-medium text-gray-700 mb-1">IdPemasok</label>
                    <input type="text" name="idPemasok" id="idPemasok" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('idPemasok') }}" required>
                    @error('idPemasok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tanggal_pesan" class="block text-sm font-medium text-gray-700 mb-1">Tanggal pesan</label>
                    <input type="date" name="tanggal_pesan" id="tanggal_pesan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('tanggal_pesan') }}" required>
                    @error('tanggal_pesan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tanggal_terima" class="block text-sm font-medium text-gray-700 mb-1">Tanggal terima</label>
                    <input type="date" name="tanggal_terima" id="tanggal_terima" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('tanggal_terima') }}" required>
                    @error('tanggal_terima')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="total_biaya" class="block text-sm font-medium text-gray-700 mb-1">Total biaya</label>
                    <input type="text" name="total_biaya" id="total_biaya" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('total_biaya') }}" required>
                    @error('total_biaya')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('pengadaan_barang.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection