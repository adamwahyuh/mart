<x-layout>
    <div class="container">
    <h3>Restock Product: {{ $product->name }}</h3>

    <form action="{{ route('batches.store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="mb-3">
            <label for="batch_code" class="form-label">Batch Code</label>
            <input type="text" name="batch_code" id="batch_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="prdouction_date" class="form-label">Production Date</label>
            <input type="date" name="prdouction_date" id="prdouction_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="expired" class="form-label">Expired Date</label>
            <input type="date" name="expired" id="expired" class="form-control">
        </div>

        <button class="btn btn-success">Simpan Batch</button>
    </form>
</div>
</x-layout>