@extends('layouts.kasir')

@section('content')
<!-- Left Side: Products -->
<div class="w-2/3 bg-gray-50 p-6 overflow-y-auto flex flex-col h-full">
    <!-- Search and Filter -->
    <div class="mb-6 flex space-x-4">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" id="searchInput" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Cari produk berdasarkan nama, merk, atau barcode...">
        </div>
        <select id="categoryFilter" class="block w-48 pl-3 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
            <option value="all">Semua Kategori</option>
            <option value="Handphone">Handphone</option>
            <option value="Provider">Provider / Pulsa</option>
            <option value="BRILink">Layanan BRILink</option>
            <option value="Aksesoris">Aksesoris</option>
        </select>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pb-20" id="productGrid">
        @forelse($products as $p)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 cursor-pointer hover:shadow-md hover:border-blue-300 transition-all product-card" 
             data-id="{{ $p->idProduk }}" 
             data-name="{{ $p->namaProduk }}" 
             data-price="{{ $p->harga_jual }}"
             data-category="{{ $p->jenisProduk }}"
             onclick="addToCart('{{ $p->idProduk }}', '{{ addslashes($p->namaProduk) }}', {{ $p->harga_jual }})">
            
            <div class="h-24 w-full bg-gray-100 rounded-lg flex items-center justify-center mb-3 text-gray-400">
                @if($p->jenisProduk == 'Handphone')
                    <i class="fas fa-mobile-alt text-4xl"></i>
                @elseif($p->jenisProduk == 'Provider')
                    <i class="fas fa-sim-card text-4xl"></i>
                @elseif($p->jenisProduk == 'BRILink')
                    <i class="fas fa-money-bill-wave text-4xl"></i>
                @else
                    <i class="fas fa-headphones text-4xl"></i>
                @endif
            </div>
            
            <div class="text-xs font-semibold text-blue-600 mb-1">{{ $p->jenisProduk }}</div>
            <h3 class="text-sm font-bold text-gray-800 leading-tight mb-2 line-clamp-2">{{ $p->namaProduk }}</h3>
            <div class="flex justify-between items-end mt-auto">
                <span class="text-xs text-gray-500">Stok: {{ $p->stok }}</span>
                <span class="text-sm font-bold text-green-600">Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</span>
            </div>
        </div>
        @empty
        <div class="col-span-full flex flex-col items-center justify-center py-12 text-gray-500">
            <i class="fas fa-box-open text-5xl mb-4 text-gray-300"></i>
            <p>Belum ada produk yang tersedia atau stok habis.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Right Side: Cart -->
<div class="w-1/3 bg-white border-l border-gray-200 flex flex-col h-full relative z-20 shadow-xl">
    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-800"><i class="fas fa-shopping-cart mr-2"></i> Keranjang</h2>
        <button onclick="clearCart()" class="text-sm text-red-500 hover:text-red-700 font-medium">Kosongkan</button>
    </div>
    
    <!-- Cart Items -->
    <div class="flex-1 overflow-y-auto p-4" id="cartItems">
        <div class="flex flex-col items-center justify-center h-full text-gray-400" id="emptyCartMessage">
            <i class="fas fa-cart-arrow-down text-5xl mb-4 text-gray-200"></i>
            <p>Keranjang masih kosong</p>
            <p class="text-sm">Klik produk di sebelah kiri untuk menambahkan</p>
        </div>
        <!-- Items will be injected here via JS -->
    </div>
    
    <!-- Payment Summary & Action -->
    <div class="border-t border-gray-200 p-6 bg-gray-50">
        <div class="flex justify-between mb-2 text-gray-600">
            <span>Subtotal</span>
            <span id="subtotalAmount" class="font-medium">Rp 0</span>
        </div>
        <div class="flex justify-between mb-4 text-gray-600">
            <span>Pajak (0%)</span>
            <span class="font-medium">Rp 0</span>
        </div>
        <div class="flex justify-between mb-6 border-t border-gray-200 pt-4">
            <span class="text-lg font-bold text-gray-800">Total</span>
            <span id="totalAmount" class="text-2xl font-bold text-blue-600">Rp 0</span>
        </div>
        
        <form action="{{ route('kasir.checkout') }}" method="POST" id="checkoutForm">
            @csrf
            <!-- Hidden input to store cart data (JSON) -->
            <input type="hidden" name="cart_data" id="cartDataInput">
            <input type="hidden" name="total" id="formTotalInput" value="0">
            
            <button type="submit" id="btnCheckout" disabled class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl shadow-lg transition-all text-lg flex items-center justify-center">
                <i class="fas fa-check-circle mr-2"></i> Bayar & Selesai
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let cart = {};

    function addToCart(id, name, price) {
        if(cart[id]) {
            cart[id].qty += 1;
        } else {
            cart[id] = { id, name, price, qty: 1 };
        }
        renderCart();
    }

    function changeQty(id, delta) {
        if(cart[id]) {
            cart[id].qty += delta;
            if(cart[id].qty <= 0) {
                delete cart[id];
            }
            renderCart();
        }
    }

    function clearCart() {
        if(confirm('Yakin ingin mengosongkan keranjang?')) {
            cart = {};
            renderCart();
        }
    }

    function renderCart() {
        const cartItemsDiv = document.getElementById('cartItems');
        const emptyMsg = document.getElementById('emptyCartMessage');
        const subtotalSpan = document.getElementById('subtotalAmount');
        const totalSpan = document.getElementById('totalAmount');
        const btnCheckout = document.getElementById('btnCheckout');
        const cartDataInput = document.getElementById('cartDataInput');
        const formTotalInput = document.getElementById('formTotalInput');

        let html = '';
        let total = 0;
        let count = 0;

        for(let id in cart) {
            const item = cart[id];
            const itemTotal = item.price * item.qty;
            total += itemTotal;
            count++;

            html += `
            <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-100 last:border-0">
                <div class="flex-1 pr-4">
                    <h4 class="text-sm font-bold text-gray-800 leading-tight mb-1">${item.name}</h4>
                    <div class="text-xs text-gray-500">Rp ${item.price.toLocaleString('id-ID')}</div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center border border-gray-200 rounded-lg">
                        <button onclick="changeQty('${id}', -1)" class="px-2 py-1 text-gray-500 hover:bg-gray-100 rounded-l-lg"><i class="fas fa-minus text-xs"></i></button>
                        <span class="px-3 font-medium text-sm w-8 text-center">${item.qty}</span>
                        <button onclick="changeQty('${id}', 1)" class="px-2 py-1 text-gray-500 hover:bg-gray-100 rounded-r-lg"><i class="fas fa-plus text-xs"></i></button>
                    </div>
                    <div class="text-sm font-bold text-gray-800 w-20 text-right">Rp ${(itemTotal).toLocaleString('id-ID')}</div>
                </div>
            </div>`;
        }

        if(count > 0) {
            emptyMsg.style.display = 'none';
            cartItemsDiv.innerHTML = html;
            btnCheckout.disabled = false;
        } else {
            emptyMsg.style.display = 'flex';
            cartItemsDiv.innerHTML = '';
            cartItemsDiv.appendChild(emptyMsg);
            btnCheckout.disabled = true;
        }

        const formattedTotal = 'Rp ' + total.toLocaleString('id-ID');
        subtotalSpan.innerText = formattedTotal;
        totalSpan.innerText = formattedTotal;
        
        cartDataInput.value = JSON.stringify(cart);
        formTotalInput.value = total;
    }

    // Filter Logic
    document.getElementById('searchInput').addEventListener('input', filterProducts);
    document.getElementById('categoryFilter').addEventListener('change', filterProducts);

    function filterProducts() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const category = document.getElementById('categoryFilter').value;
        const cards = document.querySelectorAll('.product-card');

        cards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const cat = card.getAttribute('data-category');
            
            const matchQuery = name.includes(query);
            const matchCat = (category === 'all' || cat === category);

            if(matchQuery && matchCat) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endpush
