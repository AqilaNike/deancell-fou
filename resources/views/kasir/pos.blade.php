@extends('layouts.kasir')

@section('content')
<!-- Toast Notification Container -->
<div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-2"></div>

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
            @php
                $categories = $products->pluck('jenisProduk')->unique()->filter();
            @endphp
            @foreach($categories as $category)
                <option value="{{ $category }}">{{ $category }}</option>
            @endforeach
        </select>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pb-20" id="productGrid">
        @forelse($products as $p)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 cursor-pointer hover:shadow-md hover:border-blue-300 transition-all product-card" 
             id="card-{{ trim($p->idProduk) }}"
             data-id="{{ trim($p->idProduk) }}" 
             data-name="{{ trim($p->namaProduk) }}" 
             data-price="{{ $p->harga_jual }}"
             data-stok="{{ $p->stok ?? 0 }}"
             data-category="{{ $p->jenisProduk }}"
             data-merk="{{ $p->merk ?? '' }}"
             onclick="addToCart('{{ trim($p->idProduk) }}')">
            
            <div class="h-24 w-full bg-gray-100 rounded-lg flex items-center justify-center mb-3 text-gray-400">
                @if($p->jenisProduk == 'Handphone')
                    <i class="fas fa-mobile-alt text-4xl"></i>
                @elseif(in_array($p->jenisProduk, ['Provider', 'Pulsa Reguler', 'Voucher Internet']))
                    <i class="fas fa-sim-card text-4xl"></i>
                @elseif(in_array($p->jenisProduk, ['BRILink', 'Layanan BRILink', 'Top Up E-Wallet']))
                    <i class="fas fa-money-bill-wave text-4xl"></i>
                @elseif($p->jenisProduk == 'Aksesoris')
                    <i class="fas fa-headphones text-4xl"></i>
                @else
                    <i class="fas fa-box text-4xl"></i>
                @endif
            </div>
            
            <div class="text-xs font-semibold text-blue-600 mb-1">{{ $p->jenisProduk }}</div>
            <h3 class="text-sm font-bold text-gray-800 leading-tight mb-2 line-clamp-2">{{ $p->namaProduk }}</h3>
            <div class="flex justify-between items-end mt-auto">
                <span class="text-xs text-gray-500 font-bold" id="display-stok-{{ trim($p->idProduk) }}">Stok: {{ $p->stok ?? 0 }}</span>
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

    <!-- Inline Top Up E-Wallet Form (hidden by default, shown when category = Top Up E-Wallet) -->
    <div id="topupInlinePanel" class="hidden pb-20">
        <div class="max-w-lg mx-auto">
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-wallet text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Top Up E-Wallet</h3>
                        <p class="text-sm text-gray-500">Pilih provider dan masukkan nominal</p>
                    </div>
                </div>

                <!-- Provider -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih E-Wallet</label>
                    <select id="topupProvider" class="block w-full pl-4 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-xl bg-white">
                        <option value="DANA">DANA</option>
                        <option value="GoPay">GoPay</option>
                        <option value="OVO">OVO</option>
                        <option value="ShopeePay">ShopeePay</option>
                        <option value="LinkAja">LinkAja</option>
                    </select>
                </div>

                <!-- Nominal -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nominal (Rp)</label>
                    <input type="number" id="topupNominal" class="block w-full pl-4 pr-4 py-3 text-lg font-bold border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 50000" min="1000" oninput="calculateTopup()">
                </div>

                <!-- Live Calculation -->
                <div id="topupCalcBox" class="bg-gray-50 rounded-xl p-5 mb-6 hidden transition-all">
                    <div class="flex justify-between mb-2 text-sm text-gray-600">
                        <span>Nominal</span>
                        <span id="topupDisplayNominal" class="font-medium">Rp 0</span>
                    </div>
                    <div class="flex justify-between mb-2 text-sm text-gray-600">
                        <span>Pajak (5%)</span>
                        <span id="topupDisplayPajak" class="font-medium text-red-500">Rp 0</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t border-gray-200">
                        <span class="text-base font-bold text-gray-800">Total</span>
                        <span id="topupDisplayTotal" class="text-lg font-black text-blue-600">Rp 0</span>
                    </div>
                </div>

                <!-- Button -->
                <button type="button" id="topupAddBtn" onclick="addTopupToCart()" disabled class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl shadow-lg transition-all text-base flex items-center justify-center">
                    <i class="fas fa-cart-plus mr-2"></i> Tambahkan ke Keranjang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Right Side: Cart -->
<div class="w-1/3 bg-white border-l border-gray-200 flex flex-col h-full relative z-20 shadow-xl">
    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-800"><i class="fas fa-shopping-cart mr-2"></i> Keranjang</h2>
        <button onclick="clearCart()" class="text-sm text-red-500 hover:text-red-700 font-medium">Kosongkan</button>
    </div>
    
    <!-- Cart Items -->
    <div class="flex-1 overflow-y-auto p-4 relative">
        <div class="flex flex-col items-center justify-center h-full text-gray-400" id="emptyCartMessage">
            <i class="fas fa-cart-arrow-down text-5xl mb-4 text-gray-200"></i>
            <p>Keranjang masih kosong</p>
            <p class="text-sm">Klik produk di sebelah kiri untuk menambahkan</p>
        </div>
        <!-- Items will be injected here via JS -->
        <div id="cartItemList"></div>
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
            <input type="hidden" name="payment_method" id="paymentMethodInput" value="Cash">
            
            <button type="button" onclick="openPaymentModal()" id="btnCheckout" disabled class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl shadow-lg transition-all text-lg flex items-center justify-center">
                <i class="fas fa-wallet mr-2"></i> Pilih Pembayaran
            </button>
        </form>
    </div>
</div>

<!-- Custom Confirm Modal -->
<div id="confirmModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-96 transform scale-95 transition-transform duration-300" id="confirmModalContent">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
        </div>
        <h3 class="text-lg font-bold text-center text-gray-800 mb-2">Kosongkan Keranjang?</h3>
        <p class="text-sm text-gray-500 text-center mb-6">Semua barang di keranjang akan dikembalikan. Tindakan ini tidak bisa dibatalkan.</p>
        <div class="flex space-x-3">
            <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition-colors focus:outline-none">Batal</button>
            <button onclick="executeClearCart()" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors focus:outline-none">Ya, Kosongkan</button>
        </div>
    </div>
</div>


<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-96 transform scale-95 transition-transform duration-300" id="paymentModalContent">
        <div class="flex items-center justify-between mb-4 border-b pb-3">
            <h3 class="text-lg font-bold text-gray-800">Pilih Metode Pembayaran</h3>
            <button type="button" onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="space-y-3 mb-6">
            <button type="button" onclick="selectPayment('Cash')" class="w-full flex items-center p-4 border rounded-xl hover:bg-blue-50 hover:border-blue-500 transition-colors focus:outline-none">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                </div>
                <div class="text-left flex-1">
                    <div class="font-bold text-gray-800">Uang Tunai (Cash)</div>
                </div>
            </button>
            
            <button type="button" onclick="selectPayment('Debit')" class="w-full flex items-center p-4 border rounded-xl hover:bg-blue-50 hover:border-blue-500 transition-colors focus:outline-none">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                    <i class="fas fa-credit-card text-blue-600"></i>
                </div>
                <div class="text-left flex-1">
                    <div class="font-bold text-gray-800">Kartu Debit</div>
                </div>
            </button>
            
            <button type="button" onclick="selectPayment('QRIS')" class="w-full flex items-center p-4 border rounded-xl hover:bg-blue-50 hover:border-blue-500 transition-colors focus:outline-none">
                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                    <i class="fas fa-qrcode text-purple-600"></i>
                </div>
                <div class="text-left flex-1">
                    <div class="font-bold text-gray-800">QRIS</div>
                </div>
            </button>
        </div>
    </div>
</div>

<!-- Success Modal -->
@if(session('success'))
<div id="successModal" class="fixed inset-0 z-[110] flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-96 transform scale-100 transition-transform duration-300 text-center">
        <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6 animate-pulse">
            <i class="fas fa-check text-green-500 text-4xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h2>
        <p class="text-gray-500 mb-8">{{ session('success') }}</p>
        <button onclick="document.getElementById('successModal').remove()" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition-colors focus:outline-none shadow-lg">Lanjutkan Penjualan</button>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    let cart = {};

    function showToast(message, type = 'error') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        
        let bgClass = type === 'error' ? 'bg-red-500' : 'bg-green-500';
        let icon = type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle';
        
        toast.className = `flex items-center text-white px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full opacity-0 ${bgClass}`;
        toast.innerHTML = `
            <i class="fas ${icon} mr-3 text-lg"></i>
            <span class="font-medium">${message}</span>
        `;
        
        container.appendChild(toast);
        
        // Trigger reflow then animate in
        void toast.offsetWidth;
        toast.classList.remove('translate-x-full', 'opacity-0');
        
        setTimeout(() => {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    function openPaymentModal() {
        if (Object.keys(cart).length === 0) return;
        
        const modal = document.getElementById('paymentModal');
        const modalContent = document.getElementById('paymentModalContent');
        modal.classList.remove('hidden');
        
        void modal.offsetWidth; // trigger reflow
        
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
    }

    function closePaymentModal() {
        const modal = document.getElementById('paymentModal');
        const modalContent = document.getElementById('paymentModalContent');
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function selectPayment(method) {
        document.getElementById('paymentMethodInput').value = method;
        document.getElementById('checkoutForm').submit();
    }

    function addToCart(id) {
        let card = document.getElementById('card-' + id);
        if(!card) return;
        
        let name = card.getAttribute('data-name');
        let price = parseFloat(card.getAttribute('data-price'));
        let stock = parseInt(card.getAttribute('data-stok'));

        processAddToCart(id, name, price, stock, false);
    }

    function processAddToCart(cartId, name, price, stock, isCustom = false, originalId = null) {
        if(cart[cartId]) {
            if(cart[cartId].qty < stock) {
                cart[cartId].qty += 1;
            } else {
                showToast('Maksimal stok tercapai untuk ' + name, 'error');
            }
        } else {
            if(stock > 0 || isCustom) { // E-Wallet or BRILink might bypass strict stock if it's digital, but we'll use stock
                cart[cartId] = { 
                    id: isCustom ? originalId : cartId, 
                    name: name, 
                    price: price, 
                    qty: 1, 
                    stock: stock,
                    isCustom: isCustom,
                    cartId: cartId
                };
            } else {
                showToast('Stok habis!', 'error');
            }
        }
        renderCart();
    }

    function changeQty(cartId, delta) {
        if(cart[cartId]) {
            let newQty = cart[cartId].qty + delta;
            if(newQty > cart[cartId].stock) {
                showToast('Maksimal stok tercapai!', 'error');
                return;
            }
            cart[cartId].qty = newQty;
            if(cart[cartId].qty <= 0) {
                delete cart[cartId];
            }
            renderCart();
        }
    }

    function clearCart() {
        if (Object.keys(cart).length === 0) {
            showToast('Keranjang sudah kosong!', 'error');
            return;
        }
        const modal = document.getElementById('confirmModal');
        const modalContent = document.getElementById('confirmModalContent');
        modal.classList.remove('hidden');
        
        // Trigger reflow for animation
        void modal.offsetWidth;
        
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
    }

    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');
        const modalContent = document.getElementById('confirmModalContent');
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function executeClearCart() {
        cart = {};
        renderCart();
        closeConfirmModal();
        showToast('Keranjang berhasil dikosongkan', 'success');
    }

    function renderCart() {
        const cartItemList = document.getElementById('cartItemList');
        const emptyMsg = document.getElementById('emptyCartMessage');
        const subtotalSpan = document.getElementById('subtotalAmount');
        const totalSpan = document.getElementById('totalAmount');
        const btnCheckout = document.getElementById('btnCheckout');
        const cartDataInput = document.getElementById('cartDataInput');
        const formTotalInput = document.getElementById('formTotalInput');

        let html = '';
        let total = 0;
        let count = 0;

        // Reset visual stock to original first for all cards
        document.querySelectorAll('.product-card').forEach(card => {
            let productId = card.getAttribute('data-id');
            let originalStock = parseInt(card.getAttribute('data-stok'));
            let displayStockEl = document.getElementById('display-stok-' + productId);
            if(displayStockEl) {
                displayStockEl.innerText = 'Stok: ' + originalStock;
            }
        });

        // Calculate total qty per real product ID (since custom items share same real ID)
        let productQtyMap = {};
        for(let cartId in cart) {
            let realId = cart[cartId].id || cartId;
            if(!productQtyMap[realId]) productQtyMap[realId] = 0;
            productQtyMap[realId] += cart[cartId].qty;
        }

        // Update visual stocks
        for(let realId in productQtyMap) {
            let card = document.getElementById('card-' + realId);
            if(card) {
                let originalStock = parseInt(card.getAttribute('data-stok'));
                let remainingStock = originalStock - productQtyMap[realId];
                let displayStockEl = document.getElementById('display-stok-' + realId);
                if(displayStockEl) {
                    displayStockEl.innerText = 'Stok: ' + remainingStock;
                }
            }
        }

        // Output cart items to send to backend (map cartId to just id for backend)
        let cartDataForBackend = {};

        for(let cartId in cart) {
            const item = cart[cartId];
            const itemTotal = item.price * item.qty;
            total += itemTotal;
            count++;
            
            // Backend expects object keyed by product ID.
            // But since one product ID could have multiple prices now, we must ensure KasirController handles it if we pass array,
            // OR we just send it keyed by cartId but make sure the real 'id' is sent.
            // But KasirController does foreach ($cartData as $idProduk => $item), so we can't have duplicate $idProduk as keys!
            // Wait, if it's top up, usually they just check out 1 nominal per transaction.
            // We'll pass cartId as key, and let backend know the real id. We'll update the backend checkout to use item.id!
            cartDataForBackend[cartId] = {
                realId: item.id,
                price: item.price,
                qty: item.qty
            };

            html += `
            <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-100 last:border-0">
                <div class="flex-1 pr-4">
                    <h4 class="text-sm font-bold text-gray-800 leading-tight mb-1">${item.name}</h4>
                    <div class="text-xs text-gray-500">Rp ${item.price.toLocaleString('id-ID')}</div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center border border-gray-200 rounded-lg">
                        <button type="button" onclick="changeQty('${cartId}', -1)" class="px-2 py-1 text-gray-500 hover:bg-gray-100 rounded-l-lg focus:outline-none"><i class="fas fa-minus text-xs"></i></button>
                        <span class="px-3 font-medium text-sm w-8 text-center">${item.qty}</span>
                        <button type="button" onclick="changeQty('${cartId}', 1)" class="px-2 py-1 text-gray-500 hover:bg-gray-100 rounded-r-lg focus:outline-none"><i class="fas fa-plus text-xs"></i></button>
                    </div>
                    <div class="text-sm font-bold text-gray-800 w-20 text-right">Rp ${(itemTotal).toLocaleString('id-ID')}</div>
                </div>
            </div>`;
        }

        if(count > 0) {
            if(emptyMsg) emptyMsg.style.display = 'none';
            cartItemList.innerHTML = html;
            btnCheckout.disabled = false;
        } else {
            if(emptyMsg) emptyMsg.style.display = 'flex';
            cartItemList.innerHTML = '';
            btnCheckout.disabled = true;
        }

        const formattedTotal = 'Rp ' + total.toLocaleString('id-ID');
        subtotalSpan.innerText = formattedTotal;
        totalSpan.innerText = formattedTotal;
        
        cartDataInput.value = JSON.stringify(cartDataForBackend);
        formTotalInput.value = total;
    }

    // Filter Logic
    document.getElementById('searchInput').addEventListener('input', filterProducts);
    document.getElementById('categoryFilter').addEventListener('change', filterProducts);

    function filterProducts() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const category = document.getElementById('categoryFilter').value;
        const cards = document.querySelectorAll('.product-card');
        const productGrid = document.getElementById('productGrid');
        const topupPanel = document.getElementById('topupInlinePanel');

        // If category is Top Up E-Wallet, hide product grid and show topup form
        if (category === 'Top Up E-Wallet') {
            productGrid.classList.add('hidden');
            topupPanel.classList.remove('hidden');
            return;
        }

        // Otherwise, show product grid and hide topup form
        productGrid.classList.remove('hidden');
        topupPanel.classList.add('hidden');

        cards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const cat = card.getAttribute('data-category');
            
            // Always hide E-Wallet products from the product grid
            if (cat === 'Top Up E-Wallet') {
                card.style.display = 'none';
                return;
            }

            const matchQuery = name.includes(query);
            const matchCat = (category === 'all' || cat === category);

            if(matchQuery && matchCat) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // === Top Up E-Wallet Functions ===

    function calculateTopup() {
        const nominal = parseFloat(document.getElementById('topupNominal').value) || 0;
        const calcBox = document.getElementById('topupCalcBox');
        const btn = document.getElementById('topupAddBtn');

        if (nominal >= 1000) {
            const pajak = Math.round(nominal * 0.05);
            const total = nominal + pajak;

            document.getElementById('topupDisplayNominal').innerText = 'Rp ' + nominal.toLocaleString('id-ID');
            document.getElementById('topupDisplayPajak').innerText = '+ Rp ' + pajak.toLocaleString('id-ID');
            document.getElementById('topupDisplayTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');

            calcBox.classList.remove('hidden');
            btn.disabled = false;
        } else {
            calcBox.classList.add('hidden');
            btn.disabled = true;
        }
    }

    function addTopupToCart() {
        const provider = document.getElementById('topupProvider').value;
        const nominal = parseFloat(document.getElementById('topupNominal').value) || 0;

        if (nominal < 1000) {
            showToast('Nominal tidak valid! Minimal Rp 1.000', 'error');
            return;
        }

        const pajak = Math.round(nominal * 0.05);
        const price = nominal + pajak;
        const cartId = 'TOPUP-' + provider + '-' + nominal;
        const name = 'Top Up ' + provider + ' Rp ' + nominal.toLocaleString('id-ID') + ' (+5% pajak)';

        // Use the first E-Wallet product ID as reference, or a generic one
        let refProductId = null;
        document.querySelectorAll('.product-card').forEach(card => {
            if (card.getAttribute('data-category') === 'Top Up E-Wallet' && !refProductId) {
                refProductId = card.getAttribute('data-id');
            }
        });

        if (cart[cartId]) {
            cart[cartId].qty += 1;
        } else {
            cart[cartId] = {
                id: refProductId || 'TOPUP',
                name: name,
                price: price,
                qty: 1,
                stock: 9999,
                isCustom: true,
                cartId: cartId
            };
        }

        renderCart();
        showToast('Top Up ' + provider + ' Rp ' + nominal.toLocaleString('id-ID') + ' ditambahkan!', 'success');

        // Reset form
        document.getElementById('topupNominal').value = '';
        document.getElementById('topupCalcBox').classList.add('hidden');
        document.getElementById('topupAddBtn').disabled = true;
    }

    // On page load, hide E-Wallet product cards from "Semua Kategori" view
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.product-card').forEach(card => {
            if (card.getAttribute('data-category') === 'Top Up E-Wallet') {
                card.style.display = 'none';
            }
        });
    });
</script>
@endpush
