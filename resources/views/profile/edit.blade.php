@extends('layouts.app')

@section('title', 'Edit Profil - FotoRental')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>
                    <h5>{{ Auth::user()->name }}</h5>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    <span class="badge bg-{{ Auth::user()->isAdmin() ? 'danger' : 'primary' }}">
                        {{ Auth::user()->isAdmin() ? 'Admin' : 'User' }}
                    </span>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-body">
                    <ul class="nav nav-pills flex-column" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" 
                                    data-bs-target="#profile" type="button" role="tab">
                                <i class="fas fa-user-edit me-2"></i>Edit Profil
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" 
                                    data-bs-target="#password" type="button" role="tab">
                                <i class="fas fa-lock me-2"></i>Ubah Password
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Edit Profile Tab -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                            <h4 class="card-title mb-4">
                                <i class="fas fa-user-edit me-2"></i>Edit Profil
                            </h4>
                            
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" 
                                               value="{{ old('name', Auth::user()->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" 
                                               value="{{ Auth::user()->email }}" readonly>
                                        <div class="form-text">Email tidak dapat diubah</div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" 
                                               value="{{ old('phone', Auth::user()->phone) }}" 
                                               placeholder="Contoh: 081234567890">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control" 
                                               value="{{ Auth::user()->isAdmin() ? 'Admin' : 'User' }}" readonly>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <h4 class="card-title mb-4">
                                <i class="fas fa-lock me-2"></i>Ubah Password
                            </h4>
                            
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Password Saat Ini</label>
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                                   id="current_password" name="current_password" required>
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password Baru</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" required minlength="6">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Minimal 6 karakter</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" required minlength="6">
                                        </div>
                                        
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-key me-2"></i>Ubah Password
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="fas fa-info-circle me-2"></i>Tips Password
                                                </h6>
                                                <ul class="small list-unstyled mb-0">
                                                    <li class="mb-2">
                                                        <i class="fas fa-check text-success me-1"></i>
                                                        Minimal 6 karakter
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-check text-success me-1"></i>
                                                        Kombinasi huruf & angka
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-check text-success me-1"></i>
                                                        Hindari password mudah
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const triggerTabList = [].slice.call(document.querySelectorAll('#profileTabs button'));
        triggerTabList.forEach(function (triggerEl) {
            const tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    });
</script>
@endpush