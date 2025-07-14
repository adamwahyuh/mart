<x-layout>
    <div class="container-fluid py-4">
        @if (session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            {{-- LEFT: PRODUCT LIST --}}
            <div class="col-md-7">
                {{-- SEARCH --}}
                <form action="{{ route('orders.create') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search..." value="{{ $query ?? '' }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>

                @if ($query)
                    <p class="text-muted">Hasil pencarian untuk: <strong>{{ $query }}</strong></p>
                @endif

                @forelse ($products->groupBy('category.name') as $category => $items)
                    <h5 class="fw-bold mb-3">{{ $category }}</h5>
                    <div class="row mb-4">
                        @foreach ($items as $product)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    @if ($product->photo)
                                        <img src="{{ asset('storage/' . $product->photo) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('img/default.png') }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title fw-bold mb-1">{{ $product->name }}</h6>
                                        <p class="text-primary mb-2">Rp{{ number_format($product->price?->sell_price ?? 0, 0, ',', '.') }}</p>
                                        <form action="{{ route('orders.addToCart', $product->id) }}" method="POST" class="mt-auto">
                                            @csrf
                                            <div class="input-group mb-2">
                                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="decreaseQty(this)">-</button>
                                                <input type="number" name="qty" class="form-control form-control-sm text-center" value="1" min="1">
                                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="increaseQty(this)">+</button>
                                            </div>
                                            <button class="btn btn-primary w-100">Tambah</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p class="text-muted">Produk tidak ditemukan.</p>
                @endforelse
            </div>

            {{-- RIGHT: CART --}}
            <div class="col-md-5">
                <div class="card">
                    <form action="{{ route('orders.placeOrder') }}" method="POST">
                        @csrf

                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Place order</span>

                            <div class="ms-auto" style="width: 150px;">
                                <select name="payment" class="form-select form-select-sm">
                                    <option value="tunai" selected>Tunai</option>
                                    <option value="qris">QRIS</option>
                                    <option value="debit">Debit</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            @if ($cartItems->count())
                                @foreach ($cartItems as $item)
                                    <div class="d-flex align-items-center border-bottom p-2">
                                        <img src="{{ $item->product->photo 
                                                ? asset('storage/' . $item->product->photo) 
                                                : asset('img/default.png') }}" 
                                            class="me-2 rounded" 
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $item->product->name }}</div>
                                            <div class="input-group input-group-sm mt-1" style="max-width: 120px;">
                                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="decreaseQty(this)">-</button>
                                                <input type="number" class="form-control form-control-sm text-center" value="{{ $item->qty }}" min="1" readonly>
                                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="increaseQty(this)">+</button>
                                            </div>
                                        </div>
                                        <div class="text-end me-3 text-primary fw-bold">
                                            Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger ms-2" onclick="submitDeleteForm({{ $item->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center py-3 text-muted">Keranjang kosong.</p>
                            @endif
                        </div>

                        @if ($cartItems->count())
                            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold text-primary">Rp{{ number_format($cart->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="p-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    Place order
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM DELETE TERSENDIRI --}}
    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function decreaseQty(btn) {
            let input = btn.parentElement.querySelector('input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function increaseQty(btn) {
            let input = btn.parentElement.querySelector('input');
            input.value = parseInt(input.value) + 1;
        }

        function submitDeleteForm(itemId) {
            const form = document.getElementById('deleteForm');
            form.action = `/orders/cart-item/${itemId}`;
            form.submit();
        }
    </script>
</x-layout>
