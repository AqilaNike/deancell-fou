@extends('layouts.admin')

@section('header_title', 'Edit Produk')

@section('content')
<div class="bg-white rounded-lg shadow-sm border-t-4 border-yellow-500 max-w-3xl">
    <div class="p-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-800">Form Edit Produk</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('produk.update', $item->idProduk) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="idProduk" class="block text-sm font-medium text-gray-700 mb-1">ID Produk</label>
                    <input type="text" name="idProduk" id="idProduk" class="w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('idProduk', $item->idProduk) }}" readonly>
                    @error('idProduk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="namaProduk" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="namaProduk" id="namaProduk" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('namaProduk', $item->namaProduk) }}" required>
                    @error('namaProduk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="harga_beli" class="block text-sm font-medium text-gray-700 mb-1">Harga Beli</label>
                    <input type="number" name="harga_beli" id="harga_beli" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('harga_beli', $item->harga_beli) }}">
                    @error('harga_beli')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual</label>
                    <input type="number" name="harga_jual" id="harga_jual" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('harga_jual', $item->harga_jual) }}">
                    @error('harga_jual')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <input type="number" name="stok" id="stok" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('stok', $item->stok) }}">
                    @error('stok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4 md:col-span-2">
                    <label for="jenisProduk" class="block text-sm font-medium text-gray-700 mb-1">Jenis Produk</label>
                    <select name="jenisProduk" id="jenisProduk" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required onchange="toggleFields()">
                        <option value="">-- Pilih Jenis Produk --</option>
                        <option value="Handphone" {{ old('jenisProduk', $item->jenisProduk) == 'Handphone' ? 'selected' : '' }}>Handphone (HP)</option>
                        <option value="Provider" {{ old('jenisProduk', $item->jenisProduk) == 'Provider' ? 'selected' : '' }}>Provider / Kuota / Pulsa</option>
                        <option value="BRILink" {{ old('jenisProduk', $item->jenisProduk) == 'BRILink' ? 'selected' : '' }}>Layanan BRILink</option>
                        <option value="Aksesoris" {{ old('jenisProduk', $item->jenisProduk) == 'Aksesoris' ? 'selected' : '' }}>Aksesoris / Lainnya</option>
                    </select>
                    @error('jenisProduk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Handphone Fields -->
            <div id="hp_fields" class="mt-4 p-4 bg-gray-50 rounded border hidden">
                <h4 class="font-bold text-gray-700 mb-3 border-b pb-2">Spesifikasi Handphone</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="merk" class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
                        <input type="text" name="merk" id="merk" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('merk', $item->merk) }}">
                    </div>
                    <div class="mb-4">
                        <label for="warna" class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                        <input type="text" name="warna" id="warna" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('warna', $item->warna) }}">
                    </div>
                    <div class="mb-4">
                        <label for="imei_sn" class="block text-sm font-medium text-gray-700 mb-1">IMEI / SN</label>
                        <input type="text" name="imei_sn" id="imei_sn" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('imei_sn', $item->imei_sn) }}">
                    </div>
                    <div class="mb-4">
                        <label for="kondisi" class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
                        <select name="kondisi" id="kondisi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="Baru" {{ old('kondisi', $item->kondisi) == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Bekas" {{ old('kondisi', $item->kondisi) == 'Bekas' ? 'selected' : '' }}>Bekas</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="garansi" class="block text-sm font-medium text-gray-700 mb-1">Garansi</label>
                        <input type="text" name="garansi" id="garansi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('garansi', $item->garansi) }}" placeholder="Contoh: 1 Tahun Resmi">
                    </div>
                    <div class="mb-4">
                        <label for="tipe_layanan_hp" class="block text-sm font-medium text-gray-700 mb-1">Tipe Layanan</label>
                        <input type="text" name="tipe_layanan_hp" id="tipe_layanan_hp" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('tipe_layanan', $item->tipe_layanan) }}" placeholder="Contoh: Servis LCD, Ganti Baterai">
                    </div>
                </div>
            </div>

            <!-- Provider Fields -->
            <div id="provider_fields" class="mt-4 p-4 bg-green-50 rounded border hidden">
                <h4 class="font-bold text-gray-700 mb-3 border-b border-green-200 pb-2">Detail Provider & Kuota</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="provider" class="block text-sm font-medium text-gray-700 mb-1">Nama Provider</label>
                        <input type="text" name="provider" id="provider" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('provider', $item->provider) }}">
                    </div>
                    <div class="mb-4 relative">
                        <label for="nominal_kuota" class="block text-sm font-medium text-gray-700 mb-1">Nominal Kuota / Pulsa</label>
                        <input type="text" name="nominal_kuota" id="nominal_kuota" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('nominal_kuota', $item->nominal_kuota) }}" placeholder="Pilih atau ketik (Contoh: Pulsa 5.000)" autocomplete="off">
                        
                        <!-- Custom Dropdown -->
                        <div id="kuota_dropdown" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg hidden max-h-48 overflow-y-auto">
                            <ul class="py-1 text-sm text-gray-700">
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors font-bold text-gray-800 bg-gray-100" onmousedown="event.preventDefault()">-- Pulsa Reguler --</li>
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between" onmousedown="selectKuota('Pulsa 5.000', 5500, 7000)"><span>Pulsa 5.000</span> <span class="text-gray-400 text-xs mt-1">Jual: Rp 7.000</span></li>
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between" onmousedown="selectKuota('Pulsa 10.000', 10500, 12000)"><span>Pulsa 10.000</span> <span class="text-gray-400 text-xs mt-1">Jual: Rp 12.000</span></li>
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between" onmousedown="selectKuota('Pulsa 20.000', 20200, 22000)"><span>Pulsa 20.000</span> <span class="text-gray-400 text-xs mt-1">Jual: Rp 22.000</span></li>
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between" onmousedown="selectKuota('Pulsa 50.000', 49500, 52000)"><span>Pulsa 50.000</span> <span class="text-gray-400 text-xs mt-1">Jual: Rp 52.000</span></li>
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between" onmousedown="selectKuota('Pulsa 100.000', 98500, 102000)"><span>Pulsa 100.000</span> <span class="text-gray-400 text-xs mt-1">Jual: Rp 102.000</span></li>
                                
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors font-bold text-gray-800 bg-gray-100 border-t" onmousedown="event.preventDefault()">-- Paket Kuota (Estimasi IM3) --</li>
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between" onmousedown="selectKuota('Kuota 3 GB', 15000, 18000)"><span>Kuota 3 GB</span> <span class="text-gray-400 text-xs mt-1">Jual: Rp 18.000</span></li>
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between" onmousedown="selectKuota('Kuota 5 GB', 25000, 28000)"><span>Kuota 5 GB</span> <span class="text-gray-400 text-xs mt-1">Jual: Rp 28.000</span></li>
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between" onmousedown="selectKuota('Kuota 11 GB', 42000, 45000)"><span>Kuota 11 GB</span> <span class="text-gray-400 text-xs mt-1">Jual: Rp 45.000</span></li>
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between" onmousedown="selectKuota('Kuota 20 GB', 65000, 70000)"><span>Kuota 20 GB</span> <span class="text-gray-400 text-xs mt-1">Jual: Rp 70.000</span></li>
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between" onmousedown="selectKuota('Kuota 30 GB', 85000, 90000)"><span>Kuota 30 GB</span> <span class="text-gray-400 text-xs mt-1">Jual: Rp 90.000</span></li>
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between" onmousedown="selectKuota('Kuota 50 GB', 110000, 115000)"><span>Kuota 50 GB</span> <span class="text-gray-400 text-xs mt-1">Jual: Rp 115.000</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="masa_aktif" class="block text-sm font-medium text-gray-700 mb-1">Masa Aktif (Hari)</label>
                        <input type="number" name="masa_aktif" id="masa_aktif" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('masa_aktif', $item->masa_aktif) }}" placeholder="Contoh: 30">
                    </div>
                    <div class="mb-4">
                        <label for="imei_sn2" class="block text-sm font-medium text-gray-700 mb-1">Serial Number (SN)</label>
                        <input type="text" name="imei_sn_provider" id="imei_sn2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('imei_sn', $item->imei_sn) }}">
                    </div>
                </div>
            </div>

            <!-- BRILink Fields -->
            <div id="brilink_fields" class="mt-4 p-4 bg-blue-50 rounded border hidden">
                <h4 class="font-bold text-gray-700 mb-3 border-b border-blue-200 pb-2">Layanan BRILink</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="biaya_admin" class="block text-sm font-medium text-gray-700 mb-1">Biaya Admin</label>
                        <input type="number" name="biaya_admin" id="biaya_admin" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('biaya_admin', $item->biaya_admin) }}">
                    </div>
                    <div class="mb-4">
                        <label for="tipe_layanan" class="block text-sm font-medium text-gray-700 mb-1">Tipe Layanan</label>
                        <input type="text" name="tipe_layanan" id="tipe_layanan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('tipe_layanan', $item->tipe_layanan) }}" placeholder="Contoh: Tarik Tunai">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('produk.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleFields() {
        const jenis = document.getElementById('jenisProduk').value;
        const hpFields = document.getElementById('hp_fields');
        const providerFields = document.getElementById('provider_fields');
        const brilinkFields = document.getElementById('brilink_fields');

        // Hide all initially
        hpFields.classList.add('hidden');
        providerFields.classList.add('hidden');
        brilinkFields.classList.add('hidden');

        // Show based on selection
        if (jenis === 'Handphone') {
            hpFields.classList.remove('hidden');
            document.getElementById('tipe_layanan_hp').name = "tipe_layanan";
            document.getElementById('tipe_layanan').name = "tipe_layanan_ignored";
        } else if (jenis === 'Provider') {
            providerFields.classList.remove('hidden');
            // Duplicate the SN logic if submitting so it goes to the correct field
            document.getElementById('imei_sn2').name = "imei_sn"; 
            document.getElementById('imei_sn').name = "imei_sn_ignored"; 
            
            document.getElementById('tipe_layanan').name = "tipe_layanan_ignored";
            document.getElementById('tipe_layanan_hp').name = "tipe_layanan_ignored";
        } else if (jenis === 'BRILink') {
            brilinkFields.classList.remove('hidden');
            document.getElementById('tipe_layanan').name = "tipe_layanan";
            document.getElementById('tipe_layanan_hp').name = "tipe_layanan_ignored";
        } else {
            document.getElementById('tipe_layanan').name = "tipe_layanan_ignored";
            document.getElementById('tipe_layanan_hp').name = "tipe_layanan_ignored";
        }
        
        if(jenis !== 'Provider') {
            document.getElementById('imei_sn').name = "imei_sn"; 
            document.getElementById('imei_sn2').name = "imei_sn_ignored";
        }
    }

    // Custom Dropdown Logic for Nominal Kuota
    const kuotaInput = document.getElementById('nominal_kuota');
    const kuotaDropdown = document.getElementById('kuota_dropdown');

    if(kuotaInput && kuotaDropdown) {
        kuotaInput.addEventListener('focus', () => {
            kuotaDropdown.classList.remove('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!kuotaInput.contains(e.target) && !kuotaDropdown.contains(e.target)) {
                kuotaDropdown.classList.add('hidden');
            }
        });
    }

    function selectKuota(value, hargaBeli, hargaJual) {
        kuotaInput.value = value;
        kuotaDropdown.classList.add('hidden');
        
        // Auto-fill harga beli & harga jual
        if (hargaBeli) document.getElementById('harga_beli').value = hargaBeli;
        if (hargaJual) document.getElementById('harga_jual').value = hargaJual;
    }

    // Run on load to restore state if validation fails
    document.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endsection