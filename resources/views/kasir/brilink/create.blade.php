<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi BRILink (Kasir)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-teal-100 border border-teal-400 text-teal-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kasir.brilink.store') }}" method="POST">
                        @csrf
                        
                        <!-- Jenis Transaksi -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="jenis_transaksi">
                                Jenis Transaksi
                            </label>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jenis_transaksi" value="Tarik Tunai" class="peer sr-only" required>
                                    <div class="rounded-lg border-2 border-gray-200 p-4 text-center peer-checked:border-teal-500 peer-checked:bg-teal-50 hover:bg-gray-50 transition">
                                        <div class="font-bold text-lg text-gray-700">Tarik Tunai</div>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jenis_transaksi" value="Setor Tunai" class="peer sr-only">
                                    <div class="rounded-lg border-2 border-gray-200 p-4 text-center peer-checked:border-teal-500 peer-checked:bg-teal-50 hover:bg-gray-50 transition">
                                        <div class="font-bold text-lg text-gray-700">Setor Tunai</div>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jenis_transaksi" value="Transfer" class="peer sr-only">
                                    <div class="rounded-lg border-2 border-gray-200 p-4 text-center peer-checked:border-teal-500 peer-checked:bg-teal-50 hover:bg-gray-50 transition">
                                        <div class="font-bold text-lg text-gray-700">Transfer</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Nominal -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="nominal">
                                Nominal Transaksi (Rp)
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-xl font-bold" id="nominal" type="number" name="nominal" placeholder="Contoh: 500000" required>
                        </div>

                        <!-- Nomor Referensi -->
                        <div class="mb-8">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="nomor_referensi">
                                Nomor Referensi (Struk EDC)
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-lg uppercase" id="nomor_referensi" type="text" name="nomor_referensi" placeholder="Masukkan No. Ref" required>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline w-full text-lg shadow-lg transform hover:-translate-y-0.5 transition" type="submit">
                                SIMPAN TRANSAKSI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-4 text-center text-sm text-gray-500">
                <p>Fee admin otomatis dihitung 5% dari nominal transaksi oleh sistem.</p>
            </div>
        </div>
    </div>
</x-app-layout>
