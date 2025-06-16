<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Nineteen's Mart</title>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Kiri -->
            <div class="col-md-6 d-none d-md-flex bg-primary-softy justify-content-center align-items-center flex-column">
                <div class="text-center">
                    <h1 class="fw-bold">Nineteen's Mart</h1>
                </div>
            </div>

            <!-- Kanan -->
            <div class="col-md-6 d-flex justify-content-center align-items-center bg-light">
                <div class="w-75">
                    <h2 class="fw-bold text-dark">Selamat Datang!</h2>
                    <p class="text-muted mb-4">Login untuk melanjutkan</p>

                    {{-- Tampilkan error jika login gagal --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</html>