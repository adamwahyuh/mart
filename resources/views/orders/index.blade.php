<x-layout>
    <div class="container-fluid py-4 mb-3 shadow-sm border-0 ">
        <h1 class="mb-4 fw-bold">Daftar Order</h1>

        @if (session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('orders.index') }}" method="GET" class="mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="q" class="form-control" placeholder="Cari ID atau Operator..." value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-auto">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
                <div class="col-md-auto ms-auto">
                    <a href="{{ route('orders.create') }}" class="btn btn-info">
                        <i class="bi bi-bag-plus"></i>
                    </a>
                </div>
            </div>
        </form>


        @forelse ($orders as $order)
            <div class="card mb-3 shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center mb-2 mb-md-0" style="min-width: 250px;">
                        <div class="me-3">
                            <span class="badge bg-secondary">
                                #{{ $order->id }}
                            </span>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">Operator: {{ $order->operator_name }}</h5>
                            <div class="text-muted small">
                                {{ $order->created_at->format('d-m-Y H:i') }}
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-2 mb-md-0">
                        <span class="badge 
                            @if($order->status == 'process') bg-warning text-dark
                            @elseif($order->status == 'done') bg-success
                            @elseif($order->status == 'cancel') bg-danger
                            @else bg-secondary
                            @endif
                        ">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="mb-2 mb-md-0">
                        <span class="badge bg-primary">
                            {{ ucfirst($order->payment) }}
                        </span>
                    </div>
                    <div class="fw-bold text-primary mb-2 mb-md-0">
                        Rp{{ number_format($order->total, 0, ',', '.') }}
                    </div>
                    <div class="d-flex flex-column flex-md-row gap-2">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus order ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="d-inline-block">
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
        @empty
            <div class="alert alert-info">
                Belum ada order.
            </div>
        @endforelse

        @if ($orders->hasPages())
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-layout>
