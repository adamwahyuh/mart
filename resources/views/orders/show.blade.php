<x-layout>
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        
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

        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-4">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>
</x-layout>
