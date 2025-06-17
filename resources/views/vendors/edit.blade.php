<title>{{ $title }}</title>

<x-layout>
    <div class="container my-5">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('vendors.index') }}">Vendor</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Vendor</li>
            </ol>
        </nav>

        <div class="card shadow-sm p-4 rounded-4" style="background-color: var(--background-white);">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h4 class="text-primary mb-0 fw-bold">{{ $title }}</h4>
                <a href="{{ route('vendors.index') }}" class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" title="Kembali">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>

            <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <!-- Nama Vendor -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Vendor</label>
                        <div class="input-group">
                            <span class="input-group-text">🏢</span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" placeholder="Contoh: Toko Sumber Rejeki" 
                                value="{{ old('name', $vendor->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">@</span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" id="email" placeholder="Contoh: email@vendor.com" 
                                value="{{ old('email', $vendor->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="col-md-6">
                        <label for="phone" class="form-label">No. Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text">📞</span>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                name="phone" id="phone" placeholder="Contoh: 081234567890" 
                                value="{{ old('phone', $vendor->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="col-md-6">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                            name="address" id="address" rows="3" 
                            placeholder="Alamat lengkap vendor...">{{ old('address', $vendor->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
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
