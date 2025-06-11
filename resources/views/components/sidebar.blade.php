<div id="sidebar" class="sidebar d-flex flex-column p-3" style="min-height: 100vh; width: 250px; background-color: #f8f9fa;">
    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }} d-flex align-items-center mb-2">
        <i class="bi bi-house-door-fill me-2"></i> Dashboard
    </a>
    <hr class="my-2">
    <a href="/order/create" class="nav-link {{ request()->is('order/create') ? 'active' : '' }} d-flex align-items-center mb-2">
        <i class="bi bi-pencil-square me-2"></i> Buat Order
    </a>
    <a href="/order" class="nav-link {{ request()->is('order') ? 'active' : '' }} d-flex align-items-center mb-2">
        <i class="bi bi-receipt me-2"></i> Lihat Order
    </a>
    <hr class="my-2">
    <a href="#" class="nav-link d-flex align-items-center mb-2">
        <i class="bi bi-graph-up me-2"></i> Pendapatan
    </a>
    <a href="#" class="nav-link d-flex align-items-center mb-2">
        <i class="bi bi-qr-code-scan me-2"></i> Lihat Qris
    </a>
    <hr class="my-2">
    <a href="/product" class="nav-link {{ request()->is('product') ? 'active' : '' }} d-flex align-items-center mb-2">
        <i class="bi bi-list-ul me-2"></i> Daftar Menu
    </a>
    <a href="/product/create" class="nav-link {{ request()->is('product/create') ? 'active' : '' }} d-flex align-items-center mb-2">
        <i class="bi bi-plus-square me-2"></i> Menu Baru
    </a>
    <hr class="my-2">
    <a href="#" class="nav-link d-flex align-items-center mb-2">
        <i class="bi bi-people me-2"></i> User
    </a>
    <div class="sidebar-footer mt-auto pt-3 border-top">
        <p class="text-primary mb-2"> {{ auth()->user()->name }} </p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">Logout</button>
        </form>
    </div>
</div>