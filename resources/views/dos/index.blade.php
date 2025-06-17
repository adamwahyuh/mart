

<x-layout>
    <div class="container py-4">
        <h1 class="mb-4">Log IP Masuk ke <code>/dos</code></h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('dos.destroyAll') }}" method="POST" onsubmit="return confirm('Yakin mau hapus semua log?')" class="mb-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash3-fill me-1"></i> Hapus Semua Log
            </button>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">IP Address</th>
                        <th scope="col">Waktu Akses</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
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
</x-layout>
