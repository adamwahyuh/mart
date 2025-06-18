<link rel="stylesheet" href="{{ asset('css/products/show.css') }}">

<x-layout :title="$product->name">

    

    <div class="container mt-4">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index') }}">Produk</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h4 class="mb-0">Detail Produk</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" title="Kembali">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                            class="m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center" 
                                    title="Hapus" 
                                    style="height: 31px;">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4 text-center">
                    @if($product->photo)
                        <img src="{{ asset('storage/' . $product->photo) }}"
                             alt="Foto Produk"
                             class="product-photo">
                    @else
                        <div class="text-muted">Tidak ada foto</div>
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="detail-group">
                        <div class="detail-label">Nama Produk:</div>
                        <div class="detail-value">{{ $product->name }}</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Kategori:</div>
                        <div class="detail-value">
                            <span class="badge badge-category">{{ $product->category->name ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Deskripsi:</div>
                        <div class="detail-value">{{ $product->description ?? '-' }}</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Harga Modal:</div>
                        <div class="detail-value">Rp {{ number_format($product->price->modal ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Harga Jual:</div>
                        <div class="detail-value">Rp {{ number_format($product->price->sell_price ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Keuntungan:</div>
                        <div class="detail-value">Rp {{ number_format($product->price->profit ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Dibuat Oleh:</div>
                        <div class="detail-value">{{ $product->operator_name }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
