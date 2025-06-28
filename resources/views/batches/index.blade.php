<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">

<x-layout :title="$title">
    <div class="container-fluid mt-4">
        <div class="card shadow-sm p-4 rounded-4" style="background-color: var(--background-white);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-primary mb-0">{{ $title }}</h4>
                <a href="{{ route('batches.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Batch
                </a>
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
                        placeholder="Cari produk, tipe movement, bulan, tahun...">
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
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Production Date</th>
                            <th>Expired</th>
                            <th>Vendor</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($batches as $index => $batch)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $batch->batch_code }}</td>
                                <td>{{ $batch->product->name ?? '-' }}</td>
                                <td>{{ $batch->stock }}</td>
                                <td>{{ $batch->prdouction_date ? \Carbon\Carbon::parse($batch->prdouction_date)->format('d-m-Y') : '-' }}</td>
                                <td>{{ $batch->expired ? \Carbon\Carbon::parse($batch->expired)->format('d-m-Y') : '-' }}</td>
                                <td>
                                    @forelse ($batch->movements as $movement)
                                        {{ $movement->vendor->name ?? '-' }}<br>
                                    @empty
                                        <span class="text-muted">-</span>
                                    @endforelse
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('batches.show', $batch->id) }}" 
                                        class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" 
                                        title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('batches.edit', $batch->id) }}" 
                                        class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center" 
                                        title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('batches.destroy', $batch->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Yakin ingin menghapus batch ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center" 
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada batch ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/timerTimeout.js') }}"></script>
</x-layout>
