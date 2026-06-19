@extends('layouts.kasir')

@section('content')
<div class="p-6 w-full overflow-y-auto">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800"><i class="fas fa-university mr-2 text-teal-600"></i>Transaksi BRILink</h2>
                <p class="text-gray-500">Input transaksi BRILink dengan cepat</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-teal-50 border-l-4 border-teal-500 text-teal-700 px-4 py-3 rounded-r-lg shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-teal-500 text-xl mr-3"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r-lg shadow-sm" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('kasir.brilink.store') }}" method="POST">
                @csrf
                
                <!-- Jenis Transaksi -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-3">
                        <i class="fas fa-exchange-alt mr-1"></i> Jenis Transaksi
                    </label>
                    <div class="grid grid-cols-3 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="jenis_transaksi" value="Tarik Tunai" class="peer sr-only" required>
                            <div class="rounded-xl border-2 border-gray-200 p-4 text-center peer-checked:border-red-500 peer-checked:bg-red-50 hover:bg-gray-50 transition-all shadow-sm">
                                <i class="fas fa-hand-holding-usd text-2xl text-red-400 mb-2"></i>
                                <div class="font-bold text-gray-700">Tarik Tunai</div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="jenis_transaksi" value="Setor Tunai" class="peer sr-only">
                            <div class="rounded-xl border-2 border-gray-200 p-4 text-center peer-checked:border-green-500 peer-checked:bg-green-50 hover:bg-gray-50 transition-all shadow-sm">
                                <i class="fas fa-piggy-bank text-2xl text-green-400 mb-2"></i>
                                <div class="font-bold text-gray-700">Setor Tunai</div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="jenis_transaksi" value="Transfer" class="peer sr-only">
                            <div class="rounded-xl border-2 border-gray-200 p-4 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 transition-all shadow-sm">
                                <i class="fas fa-paper-plane text-2xl text-blue-400 mb-2"></i>
                                <div class="font-bold text-gray-700">Transfer</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Nominal -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nominal">
                        <i class="fas fa-money-bill-wave mr-1"></i> Nominal Transaksi (Rp)
                    </label>
                    <input class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 text-xl font-bold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition" id="nominal" type="number" name="nominal" placeholder="Contoh: 500000" required>
                    <p class="text-xs text-gray-400 mt-1">Fee admin 5% otomatis dihitung oleh sistem</p>
                </div>

                <!-- Preview Fee -->
                <div class="mb-6 bg-gray-50 rounded-lg p-4 border border-gray-200" id="feePreview" style="display:none;">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Estimasi Fee Admin (5%):</span>
                        <span class="text-teal-600 font-bold text-lg" id="feeAmount">Rp 0</span>
                    </div>
                </div>

                <!-- Nomor Referensi -->
                <div class="mb-8">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nomor_referensi">
                        <i class="fas fa-receipt mr-1"></i> Nomor Referensi (Struk EDC)
                    </label>
                    <input class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 text-lg uppercase focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition" id="nomor_referensi" type="text" name="nomor_referensi" placeholder="Masukkan No. Ref dari struk" required>
                </div>

                <button class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-4 px-6 rounded-xl text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all" type="submit">
                    <i class="fas fa-save mr-2"></i> SIMPAN TRANSAKSI
                </button>
            </form>
        </div>
        
        <div class="mt-4 text-center text-sm text-gray-400">
            <i class="fas fa-info-circle mr-1"></i> Fee admin otomatis dihitung 5% dari nominal transaksi oleh sistem.
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const nominalInput = document.getElementById('nominal');
    const feePreview = document.getElementById('feePreview');
    const feeAmount = document.getElementById('feeAmount');

    nominalInput.addEventListener('input', function() {
        const nominal = parseFloat(this.value) || 0;
        if (nominal > 0) {
            const fee = nominal * 0.05;
            feeAmount.textContent = 'Rp ' + fee.toLocaleString('id-ID');
            feePreview.style.display = 'block';
        } else {
            feePreview.style.display = 'none';
        }
    });
</script>
@endpush
