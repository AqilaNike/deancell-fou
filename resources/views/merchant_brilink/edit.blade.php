@extends('layouts.admin')

@section('header_title', 'Edit MerchantBrilink')

@section('content')
<div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-500 max-w-3xl">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-800">Form Edit MerchantBrilink</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('merchant_brilink.update', $item->id_merchant) }}" method="POST">
            @csrf
            @method('PUT')
            
                <div class="mb-4">
                    <label for="id_merchant" class="block text-sm font-medium text-gray-700 mb-1">Id merchant</label>
                    <input type="text" name="id_merchant" id="id_merchant" readonly class="w-full rounded-md border-gray-300 bg-gray-100 shadow-sm" value="{{ old('id_merchant', $item->id_merchant) }}" required>
                    @error('id_merchant')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="no_agen_bri" class="block text-sm font-medium text-gray-700 mb-1">No agen bri</label>
                    <input type="text" name="no_agen_bri" id="no_agen_bri" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('no_agen_bri', $item->no_agen_bri) }}" required>
                    @error('no_agen_bri')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nama_toko" class="block text-sm font-medium text-gray-700 mb-1">Nama toko</label>
                    <input type="text" name="nama_toko" id="nama_toko" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('nama_toko', $item->nama_toko) }}" required>
                    @error('nama_toko')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="pemilik" class="block text-sm font-medium text-gray-700 mb-1">Pemilik</label>
                    <input type="text" name="pemilik" id="pemilik" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('pemilik', $item->pemilik) }}" required>
                    @error('pemilik')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="no_hp_terdaftar" class="block text-sm font-medium text-gray-700 mb-1">No hp terdaftar</label>
                    <input type="text" name="no_hp_terdaftar" id="no_hp_terdaftar" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('no_hp_terdaftar', $item->no_hp_terdaftar) }}" required>
                    @error('no_hp_terdaftar')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tipe_perangkat" class="block text-sm font-medium text-gray-700 mb-1">Tipe perangkat</label>
                    <input type="text" name="tipe_perangkat" id="tipe_perangkat" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('tipe_perangkat', $item->tipe_perangkat) }}" required>
                    @error('tipe_perangkat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="saldo_limit" class="block text-sm font-medium text-gray-700 mb-1">Saldo limit</label>
                    <input type="text" name="saldo_limit" id="saldo_limit" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('saldo_limit', $item->saldo_limit) }}" required>
                    @error('saldo_limit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="no_rekening_operasional" class="block text-sm font-medium text-gray-700 mb-1">No rekening operasional</label>
                    <input type="text" name="no_rekening_operasional" id="no_rekening_operasional" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('no_rekening_operasional', $item->no_rekening_operasional) }}" required>
                    @error('no_rekening_operasional')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="kantor_wilayah" class="block text-sm font-medium text-gray-700 mb-1">Kantor wilayah</label>
                    <input type="text" name="kantor_wilayah" id="kantor_wilayah" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('kantor_wilayah', $item->kantor_wilayah) }}" required>
                    @error('kantor_wilayah')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="target_bulanan" class="block text-sm font-medium text-gray-700 mb-1">Target bulanan</label>
                    <input type="text" name="target_bulanan" id="target_bulanan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('target_bulanan', $item->target_bulanan) }}" required>
                    @error('target_bulanan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="status_aktif" class="block text-sm font-medium text-gray-700 mb-1">Status aktif</label>
                    <select name="status_aktif" id="status_aktif" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                        <option value="1" {{ old('status_aktif', $item->status_aktif) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status_aktif', $item->status_aktif) == '0' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                    @error('status_aktif')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="alamat_toko" class="block text-sm font-medium text-gray-700 mb-1">Alamat toko</label>
                    <input type="text" name="alamat_toko" id="alamat_toko" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('alamat_toko', $item->alamat_toko) }}" required>
                    @error('alamat_toko')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('merchant_brilink.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection