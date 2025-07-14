<x-layout>
    <div class="container-fluid py-5">

        {{-- SECTION: Order Summary --}}
        <section class="bg-white p-4 rounded-4 shadow border mb-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <h2 class="h4 fw-bold text-dark mb-0">Ringkasan Order</h2>
            </div>

            <div class="row g-4">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card h-100 border-0 shadow-sm" style="background: #fee2e2;">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar-day-fill" style="font-size: 3rem; color: #dc2626;"></i>
                            <div class="text-uppercase small fw-bold text-danger mt-2">Order Hari Ini</div>
                            <div class="display-5 fw-bold text-dark">{{ $totalTodayOrder }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card h-100 border-0 shadow-sm" style="background: #dbeafe;">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar-week-fill" style="font-size: 3rem; color: #2563eb;"></i>
                            <div class="text-uppercase small fw-bold text-primary mt-2">Order Minggu Ini</div>
                            <div class="display-5 fw-bold text-dark">{{ $totalWeekOrder }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card h-100 border-0 shadow-sm" style="background: #fef9c3;">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar-month-fill" style="font-size: 3rem; color: #ca8a04;"></i>
                            <div class="text-uppercase small fw-bold text-warning mt-2">Order Bulan Ini</div>
                            <div class="display-5 fw-bold text-dark">{{ $totalMonthOrder }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card h-100 border-0 shadow-sm" style="background: #dcfce7;">
                        <div class="card-body text-center">
                            <i class="bi bi-bag-fill" style="font-size: 3rem; color: #16a34a;"></i>
                            <div class="text-uppercase small fw-bold text-success mt-2">Total Semua Order</div>
                            <div class="display-5 fw-bold text-dark">{{ $totalOrder }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION: Operator --}}
        <section class="bg-white p-4 rounded-4 shadow border mb-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <h2 class="h4 fw-bold text-dark mb-0">Operator</h2>
            </div>

            <div class="row g-4">
                @forelse($operators as $operator)
                    <div class="col-md-6">
                        <div class="card shadow border-0">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-person-badge"></i> {{ $operator->name }}
                                </h5>
                                <span class="badge bg-light text-primary">{{ $operator->orders->count() }} Orders</span>
                            </div>
                            <div class="card-body p-0">
                                @if($operator->orders->count())
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Payment</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Waktu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($operator->orders as $order)
                                                    <tr>
                                                        <td>{{ $order->id }}</td>
                                                        <td>
                                                            <span class="badge bg-secondary">{{ ucfirst($order->payment) }}</span>
                                                        </td>
                                                        <td>
                                                            @php
                                                                $statusColors = [
                                                                    'process' => 'warning',
                                                                    'done'    => 'success',
                                                                    'cancel'  => 'danger',
                                                                ];
                                                            @endphp
                                                            <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </td>
                                                        <td>Rp{{ number_format($order->total, 2, ',', '.') }}</td>
                                                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="p-3 text-muted">
                                        Belum ada order.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada data operator.</p>
                @endforelse
            </div>
        </section>

        {{-- SECTION: Produk --}}
        <section class="bg-white p-4 rounded-4 shadow border mb-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <h2 class="h4 fw-bold text-dark mb-0">Produk</h2>
                <a href="{{ route('products.index') }}" class="btn btn-info text-white">
                    <i class="bi bi-box"></i> Lihat Semua Produk
                </a>
            </div>

            <div class="row g-4">
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="card h-100 border-0 shadow-sm" style="background: #cffafe;">
                        <div class="card-body text-center">
                            <i class="bi bi-box-seam-fill" style="font-size: 3rem; color: #0891b2;"></i>
                            <div class="text-uppercase small fw-bold text-info mt-2">Total Produk</div>
                            <div class="display-5 fw-bold text-dark">{{ $totalProduct }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-2">
                    <div class="card h-100 border-0 shadow-sm" style="background: #d1fae5;">
                        <div class="card-body text-center">
                            <i class="bi bi-image-fill" style="font-size: 3rem; color: #047857;"></i>
                            <div class="text-uppercase small fw-bold text-success mt-2">Total Foto Produk</div>
                            <div class="display-5 fw-bold text-dark">{{ $totalProduct }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- SECTION: Batch --}}
        <section class="bg-white p-4 rounded-4 shadow border mb-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <h2 class="h4 fw-bold text-dark mb-0">Batch</h2>
                <a href="{{ route('batches.index') }}" class="btn btn-info text-white">
                    <i class="bi bi-box"></i> Lihat Semua Batch
                </a>
            </div>

            <div class="row g-4">
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="card h-100 border-0 shadow-sm" style="background: #cffafe;">
                        <div class="card-body text-center">
                            <i class="bi bi-box-seam-fill" style="font-size: 3rem; color: #0891b2;"></i>
                            <div class="text-uppercase small fw-bold text-info mt-2">Total Batch</div>
                            <div class="display-5 fw-bold text-dark">{{ $totalBatch }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- SECTION: Movement History --}}
        <section class="bg-white p-4 rounded-4 shadow border mb-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <h2 class="h4 fw-bold text-dark mb-0">Riwayat Movement</h2>
                <a href="{{ route('movements.index') }}" class="btn btn-info text-white">
                    <i class="bi bi-clock-history"></i> Lihat Semua Movement
                </a>
            </div>

            @if($latestMovements->count())
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tipe</th>
                                <th>Batch</th>
                                <th>Vendor</th>
                                <th>Qty</th>
                                <th>Operator</th>
                                <th>Waktu</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestMovements as $movement)
                                <tr>
                                    <td>{{ $movement->id }}</td>
                                    <td>
                                        @if($movement->type === 'in')
                                            <span class="badge bg-success">IN</span>
                                        @else
                                            <span class="badge bg-danger">OUT</span>
                                        @endif
                                    </td>
                                    <td>{{ $movement->batch->batch_code ?? '-' }}</td>
                                    <td>{{ $movement->vendor->name ?? '-' }}</td>
                                    <td>{{ $movement->quantity }}</td>
                                    <td>{{ $movement->operator_name }}</td>
                                    <td>{{ $movement->created_at->format('d-m-Y H:i') }}</td>
                                    <td>{{ $movement->note ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $latestMovements->links() }}
                </div>
            @else
                <div class="text-muted p-3">
                    Belum ada data movement.
                </div>
            @endif
        </section>

        {{-- SECTION: Vendor --}}
        <section class="bg-white p-4 rounded-4 shadow border mb-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <h2 class="h4 fw-bold text-dark mb-0">Daftar Vendor</h2>
                <a href="{{ route('vendors.index') }}" class="btn btn-info text-white">
                    <i class="bi bi-building"></i> Lihat Semua Vendor
                </a>
            </div>

            @if ($vendors->count())
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Vendor</th>
                                <th>Kontak</th>
                                <th>Alamat</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $vendor)
                                <tr>
                                    <td>{{ $vendor->id }}</td>
                                    <td>{{ $vendor->name }}</td>
                                    <td>{{ $vendor->contact ?? '-' }}</td>
                                    <td>{{ $vendor->address ?? '-' }}</td>
                                    <td>{{ $vendor->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $vendors->links() }}
                </div>
            @else
                <div class="p-3 text-muted">
                    Belum ada data vendor.
                </div>
            @endif
        </section>


    </div>
</x-layout>
