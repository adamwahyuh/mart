<x-layout :title="'Detail Batch: '.$batch->batch_code">
    <div class="container my-4">
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('batches.index') }}">Batch</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $batch->batch_code }}
                </li>
            </ol>
        </nav>

        <div class="card shadow-sm p-4 rounded-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h4 class="text-primary mb-0 fw-bold">Detail Batch</h4>
                <a href="{{ route('batches.index') }}" 
                   class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" 
                   title="Kembali">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>

            {{-- DETAIL BATCH --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-2"><strong>Batch Code:</strong> {{ $batch->batch_code }}</div>
                    <div class="mb-2"><strong>Produk:</strong> {{ $batch->product->name ?? '-' }}</div>
                    <div class="mb-2"><strong>Stock Saat Ini:</strong> {{ $batch->stock }}</div>
                    <div class="mb-2"><strong>Production Date:</strong> 
                        {{ $batch->production_date ? \Carbon\Carbon::parse($batch->production_date)->format('d-m-Y') : '-' }}
                    </div>
                    <div class="mb-2"><strong>Expired:</strong> 
                        {{ $batch->expired ? \Carbon\Carbon::parse($batch->expired)->format('d-m-Y') : '-' }}
                    </div>
                </div>
            </div>

            {{-- TABLE MOVEMENTS --}}
            <h5 class="fw-bold text-primary">Riwayat Movement</h5>

            @if($batch->movements->count())
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Vendor</th>
                                <th>Tipe</th>
                                <th>Qty</th>
                                <th>Note</th>
                                <th>Operator</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($batch->movements as $index => $movement)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $movement->vendor->name ?? '-' }}</td>
                                    <td>
                                        @if($movement->type == 'in')
                                            <span class="badge bg-success">IN</span>
                                        @elseif($movement->type == 'out')
                                            <span class="badge bg-danger">OUT</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $movement->quantity }}</td>
                                    <td>{{ $movement->note ?? '-' }}</td>
                                    <td>{{ $movement->operator_name }}</td>
                                    <td>{{ $movement->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Belum ada data movement untuk batch ini.</p>
            @endif

        </div>
    </div>
</x-layout>
