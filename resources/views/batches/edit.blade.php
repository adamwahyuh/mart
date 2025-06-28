<x-layout :title="$title . ': ' . $batch->batch_code">
    <div class="container my-5">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('batches.index') }}">Batch</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit : {{ $batch->batch_code }}</li>
            </ol>
        </nav>

        <div class="card shadow-sm p-4 rounded-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h4 class="text-primary mb-0 fw-bold">Edit Batch</h4>
                <a href="{{ route('batches.index') }}" class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" title="Kembali">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>

            <form action="{{ route('batches.update', $batch->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    {{-- Batch Code (readonly) --}}
                    <div class="col-md-6">
                        <label class="form-label">Batch Code</label>
                        <input type="text" class="form-control" value="{{ $batch->batch_code }}" readonly>
                    </div>

                    {{-- Product Name (readonly) --}}
                    <div class="col-md-6">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" value="{{ $batch->product->name ?? '-' }}" readonly>
                    </div>

                    {{-- Production Date --}}
                    <div class="col-md-6">
                        <label for="prdouction_date" class="form-label">Production Date</label>
                        <input type="date" 
                            name="prdouction_date" 
                            id="prdouction_date" 
                            class="form-control @error('prdouction_date') is-invalid @enderror"
                            value="{{ old('prdouction_date', $batch->prdouction_date) }}">
                        @error('prdouction_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Expired Date --}}
                    <div class="col-md-6">
                        <label for="expired" class="form-label">Expired Date</label>
                        <input type="date" 
                            name="expired" 
                            id="expired" 
                            class="form-control @error('expired') is-invalid @enderror"
                            value="{{ old('expired', $batch->expired) }}">
                        @error('expired')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Tombol Submit --}}
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success btn-sm px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                            <i class="bi bi-save2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-layout>
