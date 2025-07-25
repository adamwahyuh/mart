<div id="sidebar" class="sidebar d-flex flex-column p-3" 
     style="height: 100vh; width: 250px; background-color: var(--sidebar-bg); color: var(--sidebar-text); box-shadow: var(--box-shadow-light); overflow-y: auto;">
     
    {{-- Brand / Header --}}
    <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }} d-flex align-items-center mb-3 fw-bold">
        <i class="bi bi-house-door-fill me-2"></i> Dashboard
    </a>

    {{-- CASHIER --}}
    <div class="mb-2">
        <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start px-2" 
                data-bs-toggle="collapse" data-bs-target="#cashier-menu" aria-expanded="false" 
                style="color: var(--sidebar-text);">
            <i class="bi bi-bag-fill me-2"></i> Cashier
        </button>
        <div class="collapse" id="cashier-menu">
            <a href="{{ route('orders.index') }}" class="nav-link ms-3 {{ request()->is('orders') ? 'active' : '' }}">
                <i class="bi bi-receipt me-2"></i> Lihat Order
            </a>
            <a href="{{ route('orders.create') }}" class="nav-link ms-3 {{ request()->is('orders/create') ? 'active' : '' }}">
                <i class="bi bi-pencil-square me-2"></i> Buat Order
            </a>
        </div>
    </div>

    {{-- Products --}}
    <div class="mb-2">
        <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start px-2" 
                data-bs-toggle="collapse" data-bs-target="#products-menu" aria-expanded="false" 
                style="color: var(--sidebar-text);">
            <i class="bi bi-box-seam me-2"></i> Products
        </button>
        <div class="collapse" id="products-menu">
            <a href="/products" class="nav-link ms-3 {{ request()->is('products') ? 'active' : '' }}">
                <i class="bi bi-list-ul me-2"></i> Daftar Menu
            </a>
            <a href="/products/create" class="nav-link ms-3 {{ request()->is('products/create') ? 'active' : '' }}">
                <i class="bi bi-plus-square me-2"></i> Menu Baru
            </a>
            <a href="/categories" class="nav-link ms-3 {{ request()->is('categories') ? 'active' : '' }}">
                <i class="bi bi-plus-square me-2"></i> Buat Categori
            </a>
        </div>
    </div>
    {{-- Stocker --}}
    <div class="mb-2">
        <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start px-2" 
                data-bs-toggle="collapse" data-bs-target="#restocker-menu" aria-expanded="false" 
                style="color: var(--sidebar-text);">
            <i class="bi bi-collection me-2"></i> Batches
        </button>
        <div class="collapse" id="restocker-menu">
            <a href="/batches" class="nav-link ms-3 {{ request()->is('batches') ? 'active' : '' }}">
                <i class="bi bi-list-ul me-2"></i> Daftar Batches
            </a>
            <a href="/batches/create" class="nav-link ms-3 {{ request()->is('batches/create') || request()->is('batches/select-product')  ? 'active' : '' }}">
                <i class="bi bi-plus-square me-2"></i> Buat Batch
            </a>
        </div>
    </div>
    {{-- Movements --}}
    <div class="mb-2">
        <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start px-2" 
                data-bs-toggle="collapse" data-bs-target="#movements-menu" aria-expanded="false" 
                style="color: var(--sidebar-text);">
            <i class="bi bi-car-front-fill me-2"></i> Movements
        </button>
        <div class="collapse" id="movements-menu">
            <a href="/movements/select-batch" class="nav-link ms-3 {{ request()->is('movements/select-batch') ? 'active' : '' }}">
                <i class="bi bi-plus-square me-2"></i> Isi/Ambil
            </a>
        </div>
        <div class="collapse" id="movements-menu">
            <a href="/movements" class="nav-link ms-3 {{ request()->is('movements') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-2"></i> Riwayat
            </a>
        </div>
    </div>

    {{-- Vendors --}}
    <div class="mb-2">
        <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start px-2" 
                data-bs-toggle="collapse" data-bs-target="#vendors-menu" aria-expanded="false" 
                style="color: var(--sidebar-text);">
            <i class="bi bi-truck me-2"></i> Vendors
        </button>
        <div class="collapse" id="vendors-menu">
            <a href="/vendors" class="nav-link ms-3 {{ request()->is('vendors') ? 'active' : '' }}">
                <i class="bi bi-list-ul me-2"></i> Daftar Vendor
            </a>
            <a href="/vendors/create" class="nav-link ms-3 {{ request()->is('vendors/create') ? 'active' : '' }}">
                <i class="bi bi-plus-square me-2"></i> Tambah Vendor
            </a>
        </div>
    </div>

    {{-- OWNER
    <div class="mb-2">
        <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start px-2" 
                data-bs-toggle="collapse" data-bs-target="#owner-menu" aria-expanded="false" 
                style="color: var(--sidebar-text);">
            <i class="bi bi-bar-chart-fill me-2"></i> Owner
        </button>
        <div class="collapse" id="owner-menu">
            <a href="#" class="nav-link ms-3">
                <i class="bi bi-graph-up me-2"></i> Pendapatan
            </a>
            <a href="#" class="nav-link ms-3">
                <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan
            </a>
        </div>
    </div>
    --}}
    {{-- ADMIN --}}
    {{-- <div class="mb-2">
        <button class="btn btn-toggle align-items-center rounded collapsed w-100 text-start px-2" 
                data-bs-toggle="collapse" data-bs-target="#admin-menu" aria-expanded="false" 
                style="color: var(--sidebar-text);">
            <i class="bi bi-gear-fill me-2"></i> Admin
        </button>
        <div class="collapse" id="admin-menu">
            <a href="#" class="nav-link ms-3">
                <i class="bi bi-people me-2"></i> Manajemen User
            </a>
            <a href="#" class="nav-link ms-3">
                <i class="bi bi-shield-lock me-2"></i> Role & Permission
            </a>
        </div>
    </div> --}}

    {{-- Footer --}}
    <div class="sidebar-footer mt-3 pt-3 border-top" style="border-color: var(--border-color);">
        <p class="text-primary mb-2"> {{ auth()->user()->name }}  
            <span class="text-black">As <span class="text-danger">{{ auth()->user()->role }}</span></span>
        </p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">Logout</button>
        </form>
    </div>
</div>
