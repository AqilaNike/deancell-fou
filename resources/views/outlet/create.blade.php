@extends('layouts.admin')

@section('header_title', 'Tambah Outlet')

@section('content')
<div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-500 max-w-3xl">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-800">Form Tambah Outlet</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('outlet.store') }}" method="POST">
            @csrf
            
                <div class="mb-4">
                    <label for="id_outlet" class="block text-sm font-medium text-gray-700 mb-1">Id outlet</label>
                    <input type="text" name="id_outlet" id="id_outlet" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('id_outlet') }}" required>
                    @error('id_outlet')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nama_outlet" class="block text-sm font-medium text-gray-700 mb-1">Nama outlet</label>
                    <input type="text" name="nama_outlet" id="nama_outlet" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('nama_outlet') }}" required>
                    @error('nama_outlet')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('alamat') }}" required>
                    @error('alamat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="no_telp_outlet" class="block text-sm font-medium text-gray-700 mb-1">No telp outlet</label>
                    <input type="text" name="no_telp_outlet" id="no_telp_outlet" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('no_telp_outlet') }}" required>
                    @error('no_telp_outlet')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nama_manajer" class="block text-sm font-medium text-gray-700 mb-1">Nama manajer</label>
                    <input type="text" name="nama_manajer" id="nama_manajer" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('nama_manajer') }}" required>
                    @error('nama_manajer')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="jam_operasional" class="block text-sm font-medium text-gray-700 mb-1">Jam operasional</label>
                    <input type="text" name="jam_operasional" id="jam_operasional" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('jam_operasional') }}" required>
                    @error('jam_operasional')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('outlet.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection