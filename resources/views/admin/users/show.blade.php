{{-- resources/views/admin/users/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail User - Admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-user me-2"></i>Detail User
            </h1>
            <p class="text-muted mb-0">Informasi lengkap akun pengguna</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        {{-- Profile Card --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 90px; height: 90px; font-size: 2rem;">
                        {{ strtoupper(substr($user->name ?? '-', 0, 1)) }}
                    </div>

                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <div class="text-muted mb-3">{{ $user->email }}</div>

                    <span class="badge bg-{{ ($user->role ?? 'user') === 'admin' ? 'danger' : 'secondary' }} px-3 py-2">
                        <i class="fas fa-{{ ($user->role ?? 'user') === 'admin' ? 'shield-alt' : 'user' }} me-1"></i>
                        {{ $user->role ?? 'user' }}
                    </span>

                    <hr class="my-4">

                    <div class="text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">User ID</span>
                            <strong>{{ $user->id }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Telepon</span>
                            <strong>{{ $user->phone ?? '-' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Bergabung</span>
                            <strong>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Section --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Akun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nama</label>
                            <div class="fw-semibold">{{ $user->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Email</label>
                            <div class="fw-semibold">{{ $user->email }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Telepon</label>
                            <div class="fw-semibold">{{ $user->phone ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Role</label>
                            <div class="fw-semibold">{{ $user->role ?? 'user' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Dibuat</label>
                            <div class="fw-semibold">
                                {{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Terakhir Update</label>
                            <div class="fw-semibold">
                                {{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : '-' }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Pastikan data user benar sebelum melakukan penghapusan.
                        </div>

                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger"
                                    {{ (auth()->id() == $user->id) ? 'disabled' : '' }}>
                                <i class="fas fa-trash me-2"></i>Hapus User
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Opsional: Summary sewa (kalau kamu punya relasi rentals) --}}
            @if(method_exists($user, 'rentals') || isset($rentalStats))
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0"><i class="fas fa-history me-2"></i>Ringkasan Penyewaan</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">
                            (Opsional) Tambahkan statistik sewa user di sini kalau controller mengirim datanya.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
