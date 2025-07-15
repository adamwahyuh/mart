<x-layout>
    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Normal Order Content --}}
        <div id="order-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold">
                    Order-{{ $order->id }}
                </h3>
                <span class="badge 
                    @if($order->status == 'done') bg-success
                    @elseif($order->status == 'process') bg-warning text-dark
                    @elseif($order->status == 'cancel') bg-danger
                    @else bg-secondary
                    @endif
                ">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <p class="mb-1 text-muted">Operator</p>
                            <p class="fw-bold">{{ $order->operator_name }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1 text-muted">Payment Method</p>
                            <span class="badge bg-primary">{{ ucfirst($order->payment) }}</span>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1 text-muted">Order Date</p>
                            <p>{{ $order->created_at->format('d-m-Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4">
                            <p class="mb-1 text-muted">Total Amount</p>
                            <p class="fw-bold text-primary">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1 text-muted">Edit Status</p>
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="process" {{ $order->status == 'process' ? 'selected' : '' }}>Process</option>
                                    <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Done</option>
                                    <option value="cancel" {{ $order->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progress Bar --}}
            <div class="progress mb-4" style="height: 20px;">
                <div class="progress-bar
                    @if($order->status == 'process') bg-warning text-dark
                    @elseif($order->status == 'done') bg-success
                    @elseif($order->status == 'cancel') bg-danger
                    @endif
                "
                role="progressbar"
                style="width: 
                    @if($order->status == 'process') 50%
                    @elseif($order->status == 'done') 100%
                    @elseif($order->status == 'cancel') 100%
                    @else 10%
                    @endif
                ">
                    {{ ucfirst($order->status) }}
                </div>
            </div>

            <h5 class="fw-bold mb-3">Products</h5>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table mb-0 table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Photo</th>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td style="width: 80px;">
                                        <img src="{{ $item->product?->photo 
                                                    ? asset('storage/' . $item->product->photo)
                                                    : asset('img/default.png') }}" 
                                             class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if($order->status == 'done')
                <button onclick="printReceipt()" class="btn btn-success mt-4">
                    <i class="bi bi-printer"></i> Print Receipt
                </button>
            @endif

            <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-4">
                <i class="bi bi-arrow-left"></i> Back to Orders
            </a>
        </div>

        {{-- STRUK BELANJA --}}
        <div id="receipt" class="d-none">
            <div style="
                font-family: monospace;
                font-size: 12px;
                width: 280px;
                margin: 0 auto;
                padding: 10px;
                border: 1px dashed #000;
            ">
                <h4 style="
                    text-align: center;
                    margin: 0 0 4px 0;
                    font-weight: bold;
                ">
                    Nineteen's Mart
                </h4>
                <p style="text-align: center; margin: 0;">Jl. Mangga Sigma</p>
                <p style="text-align: center; margin: 0 0 8px 0;">Tangerang</p>
                <hr style="margin: 4px 0; border-top: 1px dashed #000;">

                <p style="margin: 0;">No Order : {{ $order->id }}</p>
                <p style="margin: 0;">Tanggal  : {{ $order->created_at->format('d-m-Y H:i') }}</p>
                <p style="margin: 0 0 8px 0;">Operator : {{ $order->operator_name }}</p>

                <hr style="margin: 4px 0; border-top: 1px dashed #000;">

                @foreach ($order->orderItems as $item)
                    <div style="display: flex; justify-content: space-between;">
                        <span>{{ $item->product_name }}</span>
                        <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div style="
                        display: flex;
                        justify-content: space-between;
                        font-size: 10px;
                        margin-bottom: 4px;
                    ">
                        <small>{{ $item->qty }} x Rp{{ number_format($item->price, 0, ',', '.') }}</small>
                    </div>
                @endforeach

                <hr style="margin: 4px 0; border-top: 1px dashed #000;">

                <div style="
                    display: flex;
                    justify-content: space-between;
                    font-weight: bold;
                    margin-bottom: 4px;
                ">
                    <span>Total:</span>
                    <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </div>

                <hr style="margin: 4px 0; border-top: 1px dashed #000;">

                <p style="
                    text-align: center;
                    margin: 8px 0 2px 0;
                    font-weight: bold;
                ">
                    Terima Kasih!
                </p>
                <p style="
                    text-align: center;
                    margin: 0;
                    font-size: 10px;
                ">
                    Simpan struk ini untuk klaim garansi
                </p>
                <p style="
                    text-align: center;
                    margin: 0;
                    font-size: 10px;
                ">
                    Follow IG @nineteensmart untuk promo terbaru!
                </p>
            </div>
        </div>


    </div>

    {{-- CSS PRINT STYLES --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #receipt, #receipt * {
                visibility: visible;
            }

            #receipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
    <script>
    function printReceipt() {
        // Sembunyikan konten halaman
        document.getElementById('order-content').style.display = 'none';

        // Tampilkan struk
        document.getElementById('receipt').classList.remove('d-none');

        // Tunggu sedikit supaya browser update DOM
        setTimeout(() => {
            window.print();

            // Setelah print, balikin tampilan
            document.getElementById('receipt').classList.add('d-none');
            document.getElementById('order-content').style.display = 'block';
        }, 500);
    }
</script>

</x-layout>
