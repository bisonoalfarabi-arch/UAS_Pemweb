{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Users - Admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-users me-2"></i>Manajemen Users
            </h1>
            <p class="text-muted mb-0">Kelola akun pengguna yang terdaftar</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Search + Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Cari</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Nama / Email">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">Semua</option>
                        <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role')=='user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="card shadow-sm">
        <div class="card-body">
            @if(isset($users) && $users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 70px;">#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Role</th>
                                <th>Bergabung</th>
                                <th class="text-end" style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="text-muted">
                                        {{ method_exists($users, 'firstItem') ? ($users->firstItem() + $loop->index) : $loop->iteration }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                 style="width: 38px; height: 38px;">
                                                {{ strtoupper(substr($user->name ?? '-', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <small class="text-muted">ID: {{ $user->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ ($user->role ?? 'user') === 'admin' ? 'danger' : 'secondary' }} px-3 py-2">
                                            <i class="fas fa-{{ ($user->role ?? 'user') === 'admin' ? 'shield-alt' : 'user' }} me-1"></i>
                                            {{ $user->role ?? 'user' }}
                                        </span>
                                    </td>
                                    <td class="text-muted">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                               class="btn btn-sm btn-outline-warning"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Disable delete untuk diri sendiri (opsional) --}}
                                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"
                                                        title="Hapus"
                                                        {{ (auth()->id() == $user->id) ? 'disabled' : '' }}>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(method_exists($users, 'links'))
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">
                            Menampilkan
                            {{ $users->firstItem() }} - {{ $users->lastItem() }}
                            dari {{ $users->total() }} data
                        </div>
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted mb-1">Belum ada user</h5>
                    <p class="text-muted mb-0">Data user akan muncul di sini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-hover tbody tr:hover { background-color: rgba(52, 152, 219, 0.05); }
</style>
@endpush
{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Users - Admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-users me-2"></i>Manajemen Users
            </h1>
            <p class="text-muted mb-0">Kelola akun pengguna yang terdaftar</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Search + Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Cari</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Nama / Email">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">Semua</option>
                        <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role')=='user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="card shadow-sm">
        <div class="card-body">
            @if(isset($users) && $users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 70px;">#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Role</th>
                                <th>Bergabung</th>
                                <th class="text-end" style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="text-muted">
                                        {{ method_exists($users, 'firstItem') ? ($users->firstItem() + $loop->index) : $loop->iteration }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                 style="width: 38px; height: 38px;">
                                                {{ strtoupper(substr($user->name ?? '-', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <small class="text-muted">ID: {{ $user->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ ($user->role ?? 'user') === 'admin' ? 'danger' : 'secondary' }} px-3 py-2">
                                            <i class="fas fa-{{ ($user->role ?? 'user') === 'admin' ? 'shield-alt' : 'user' }} me-1"></i>
                                            {{ $user->role ?? 'user' }}
                                        </span>
                                    </td>
                                    <td class="text-muted">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                               class="btn btn-sm btn-outline-warning"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Disable delete untuk diri sendiri (opsional) --}}
                                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"
                                                        title="Hapus"
                                                        {{ (auth()->id() == $user->id) ? 'disabled' : '' }}>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(method_exists($users, 'links'))
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">
                            Menampilkan
                            {{ $users->firstItem() }} - {{ $users->lastItem() }}
                            dari {{ $users->total() }} data
                        </div>
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted mb-1">Belum ada user</h5>
                    <p class="text-muted mb-0">Data user akan muncul di sini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-hover tbody tr:hover { background-color: rgba(52, 152, 219, 0.05); }
</style>
@endpush
