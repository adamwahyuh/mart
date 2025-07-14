<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">

<x-layout :title="$title">
    <div class="container-fluid mt-4">
        <div class="card shadow-sm p-4 rounded-4" style="background-color: var(--background-white);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-primary mb-0">Riwayat : {{ $title }}</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('batches.index') }}" class="btn btn-success">
                        <i class="bi bi-eye me-1"></i> Lihat Daftar Batch
                    </a>
                    <a href="{{ route('movements.select-batch') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Movement
                    </a>
                </div>
            </div>

            {{-- Alert Success --}}
            @if (session('success'))
                <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- SINGLE SEARCH BAR --}}
            <form method="GET" class="row g-2 mb-4">
                <div class="col-md-6">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        class="form-control" 
                        placeholder="Cari batch code, vendor, operator...">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Batch Code</th>
                            <th>Type</th>
                            <th>Qty</th>
                            <th>Note</th>
                            <th>Vendor</th>
                            <th>Operator</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movements as $index => $movement)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $movement->batch->batch_code ?? '-' }}</td>
                                <td>
                                    @if ($movement->type == 'in')
                                        <span class="badge bg-success">In</span>
                                    @else
                                        <span class="badge bg-danger">Out</span>
                                    @endif
                                </td>
                                <td>{{ $movement->quantity }}</td>
                                <td>{{ $movement->note ?? '-' }}</td>
                                <td>{{ $movement->vendor->name ?? '-' }}</td>
                                <td>{{ $movement->operator_name }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('batches.show', $movement->batch->id) }}" 
                                        class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" 
                                        title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada movement ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/timerTimeout.js') }}"></script>
</x-layout>
