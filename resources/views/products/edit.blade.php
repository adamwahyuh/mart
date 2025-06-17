<title>Edit Produk</title>

<x-layout>
    <div class="container my-5">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index') }}">Produk</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
            </ol>
        </nav>

        <div class="card shadow-sm p-4 rounded-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h4 class="text-primary mb-0 fw-bold">Edit Produk</h4>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" title="Kembali">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>

            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Nama Produk -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Produk</label>
                        <div class="input-group">
                            <span class="input-group-text">📦</span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" placeholder="Contoh: Donat Cokelat" 
                                value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                            name="category_id" required>
                            <option value="" disabled>Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Harga Modal -->
                    <div class="col-md-6">
                        <label for="modal" class="form-label">Harga Modal</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('modal') is-invalid @enderror" 
                                name="modal" id="modal" placeholder="Contoh: 8000" 
                                value="{{ old('modal', $product->price->modal) }}" required>
                            @error('modal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Harga Jual -->
                    <div class="col-md-6">
                        <label for="sell_price" class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('sell_price') is-invalid @enderror" 
                                name="sell_price" id="sell_price" placeholder="Contoh: 10000" 
                                value="{{ old('sell_price', $product->price->sell_price) }}" required>
                            @error('sell_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-md-6">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                            name="description" id="description" rows="3" 
                            placeholder="Deskripsi produk..." required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto -->
                    <div class="col-md-6">
                        <label for="photo" class="form-label">Foto Produk (Kosongkan jika tidak ingin ganti)</label>
                        <input class="form-control @error('photo') is-invalid @enderror" 
                            type="file" id="photo" name="photo" 
                            accept="image/png, image/jpeg, image/jpg">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <p class="mt-3">Foto Lama: </p>
                        @if ($product->photo)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $product->photo) }}" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                        @endif
                        <p class="mt-3">Foto Baru: </p>
                        <div id="img-preview" class="mt-3"></div>
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

    <script>
        const photoInput = document.getElementById('photo');
        const imgPreview = document.getElementById('img-preview');

        photoInput.addEventListener('change', function () {
            imgPreview.innerHTML = '';
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    img.classList.add('img-thumbnail');
                    img.style.maxWidth = '200px';
                    img.style.height = 'auto';
                    imgPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-layout>
