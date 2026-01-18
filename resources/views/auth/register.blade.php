<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - FotoRental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .register-card {
            max-width: 500px;
            margin: 50px auto;
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        .card-header {
            background-color: #3498db;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 12px 12px 0 0 !important;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card register-card">
            <div class="card-header">
                <h4 class="mb-0">Daftar Akun Baru</h4>
                <p class="mb-0 small opacity-75">Bergabunglah dengan FotoRental</p>
            </div>
            <div class="card-body p-4">
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Alamat Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="nama@email.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required placeholder="0812...">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mt-2">
                        <i class="fas fa-user-plus me-1"></i> Daftar Sekarang
                    </button>
                    
                    <div class="text-center mt-4">
                        <p class="small text-muted mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login disini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>