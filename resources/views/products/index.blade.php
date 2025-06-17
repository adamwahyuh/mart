<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
<title>{{ $title }}</title>

<x-layout>
    <div class="container-fluid mt-4">
        <div class="card shadow-sm p-4 rounded-4" style="background-color: var(--background-white);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-primary mb-0">{{ $title }}</h4>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Produk
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Foto</th>
                            <th style="max-width: 200px;">Deskripsi</th>
                            <th>Modal</th>
                            <th>Harga Jual</th>
                            <th>Profit</th>
                            <th>Operator</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>
                                <img src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('img/default.png') }}"
                                     alt="{{ $product->name }}" class="product-img">
                            </td>
                            <td>
                                <div class="desc-text" title="{{ $product->description }}">
                                    {{ $product->description }}
                                </div>
                            </td>
                            <td>Rp {{ number_format($product->price->modal ?? 0, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($product->price->sell_price ?? 0, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($product->price->profit ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $product->operator_name }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-info" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Tidak ada produk ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
