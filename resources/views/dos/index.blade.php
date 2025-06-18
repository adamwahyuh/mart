<x-layout>
    <div class="container mt-4">
        <div class="card shadow-sm p-4 rounded-4" style="background-color: var(--background-white);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-primary mb-0">Log IP </h4>
                <div class="d-flex align-items-center gap-3">
                    <form action="{{ route('dos.destroyAll') }}" method="POST" onsubmit="return confirm('Hapus semua log?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash3-fill me-1"></i> Hapus Semua Log
                        </button>
                    </form>
                    <span class="text-muted">Total Log: <strong>{{ $logs->count() }}</strong></span>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>IP Address</th>
                            <th>Waktu Akses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $log->ip_address }}</td>
                                <td>{{ $log->accessed_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada log.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/timerTimeout.js') }}"></script>
</x-layout>
