<x-layout :title="'Restock Produk - ' . $product->name">
    <div class="container my-5">
        <div class="card shadow-sm p-4 rounded-4" style="background-color: var(--background-white);">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h4 class="text-primary mb-0 fw-bold">
                    Restock Produk: {{ $product->name }} <br>
                    <small class="text-muted">Batch: {{ $batch->batch_code }}</small>
                    <br>
                    <small>Stock: {{ $batch->stock }}</small>
                </h4>
                <a href="{{ route('movements.select-batch') }}" class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" title="Kembali">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>

            <form action="{{ route('movements.store') }}" method="POST">
                @csrf
                <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="row g-4">

                    <!-- Vendor -->
                    <div class="col-md-6">
                        <label for="vendor_id" class="form-label">Vendor</label>
                        <select name="vendor_id" id="vendor_id" class="form-select @error('vendor_id') is-invalid @enderror" required>
                            <option value="" disabled {{ old('vendor_id') ? '' : 'selected' }}>Pilih vendor</option>
                            <option value="0" {{ old('vendor_id') == 0 ? 'selected' : '' }}>Tidak Ada Vendor</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('vendor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="col-md-6">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>Pilih Type</option>
                            <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>In</option>
                            <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Out</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div class="col-md-6">
                        <label for="quantity" class="form-label">Quantity</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" placeholder="Contoh: 50" value="{{ old('quantity') }}" required min="1">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="col-md-12">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea class="form-control @error('note') is-invalid @enderror"
                            name="note" id="note" rows="3" placeholder="Keterangan tambahan...">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success btn-sm px-4 py-2 d-flex align-items-center gap-2 shadow-sm">
                            <i class="bi bi-check-circle"></i> Simpan Restock
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
