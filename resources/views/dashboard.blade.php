@extends('layouts.app')

@section('title', 'Dashboard - FotoRental')

@section('content')
<div class="container">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">Dashboard</h1>
                    <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}!</p>
                </div>
                <div>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-tachometer-alt"></i> Admin Panel
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card stat-primary shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-primary small fw-bold mb-1">Total Penyewaan</div>
                            <div class="h5 mb-0 fw-bold">
                                {{ isset($stats) ? $stats['totalRentals'] ?? 0 : 0 }}
                            </div>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-list fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card stat-success shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-success small fw-bold mb-1">Aktif</div>
                            <div class="h5 mb-0 fw-bold">
                                {{ isset($stats) ? $stats['activeRentals'] ?? 0 : 0 }}
                            </div>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-play-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card stat-warning shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-warning small fw-bold mb-1">Pending</div>
                            <div class="h5 mb-0 fw-bold">
                                {{ isset($stats) ? $stats['pendingRentals'] ?? 0 : 0 }}
                            </div>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-clock fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card stat-info shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-info small fw-bold mb-1">Total Belanja</div>
                            <div class="h5 mb-0 fw-bold">
                                Rp {{ isset($stats) ? number_format($stats['totalSpent'] ?? 0, 0, ',', '.') : '0' }}
                            </div>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-bolt text-warning"></i> Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-6 mb-2">
                            <a href="{{ route('catalog.index') }}" class="btn btn-primary w-100">
                                <i class="fas fa-camera"></i> Sewa Peralatan
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <a href="{{ route('rentals.my') }}" class="btn btn-success w-100">
                                <i class="fas fa-history"></i> Penyewaan Saya
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-info w-100 text-white">
                                <i class="fas fa-user-edit"></i> Edit Profil
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <a href="{{ route('catalog.index') }}" class="btn btn-warning w-100">
                                <i class="fas fa-search"></i> Jelajahi Katalog
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Rentals -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0"><i class="fas fa-history text-primary"></i> Penyewaan Terbaru</h5>
                    <a href="{{ route('rentals.my') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @php
                        $recentRentals = $recentRentals ?? collect([]);
                    @endphp

                    @if($recentRentals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Peralatan</th>
                                        <th>Tanggal Sewa</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRentals as $rental)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($rental->equipment->image ?? false)
                                                    <img src="{{ asset('storage/' . $rental->equipment->image) }}"
                                                         alt="{{ $rental->equipment->name }}"
                                                         class="rounded me-2"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-2"
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-camera text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold">{{ $rental->equipment->name ?? 'N/A' }}</div>
                                                    <small class="text-muted">
                                                        Rp {{ number_format($rental->total_price ?? 0, 0, ',', '.') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ isset($rental->rental_date) ? \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'active' => 'primary',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger'
                                                ];
                                                $status = $rental->status ?? 'pending';
                                            @endphp
                                            <span class="badge bg-{{ $statusColors[$status] ?? 'secondary' }}">
                                                {{ $status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if(isset($rental->id))
                                                <a href="{{ route('rentals.show', $rental) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-clipboard-list fa-3x text-muted"></i>
                            </div>
                            <h5 class="text-muted">Belum ada penyewaan</h5>
                            <p class="text-muted mb-3">Mulai dengan menyewa peralatan pertama Anda</p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                                <i class="fas fa-camera"></i> Sewa Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Recommended Equipment -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-star text-warning"></i> Rekomendasi</h5>
                </div>
                <div class="card-body">
                    @php
                        $recommendedEquipment = $recommendedEquipment ?? collect([]);
                    @endphp

                    @if($recommendedEquipment->count() > 0)
                        @foreach($recommendedEquipment as $equipment)
                        <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="d-flex align-items-start">
                                @if($equipment->image ?? false)
                                    <img src="{{ asset('storage/' . $equipment->image) }}"
                                         alt="{{ $equipment->name }}"
                                         class="rounded me-3"
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-3"
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-camera text-muted"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h6 class="mb-1">{{ $equipment->name ?? 'N/A' }}</h6>
                                    <p class="text-muted small mb-1">
                                        Rp {{ number_format($equipment->price_per_day ?? 0, 0, ',', '.') }}/hari
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-{{ ($equipment->stock ?? 0) > 0 ? 'success' : 'danger' }}">
                                            {{ $equipment->stock ?? 0 }} stok
                                        </span>
                                        @if(isset($equipment->id))
                                            <a href="{{ route('catalog.show', $equipment->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="text-center">
                            <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-boxes"></i> Lihat Semua Peralatan
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <div class="mb-3">
                                <i class="fas fa-box-open fa-3x text-muted"></i>
                            </div>
                            <p class="text-muted">Tidak ada rekomendasi saat ini</p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-sm btn-outline-primary">
                                Jelajahi Katalog
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- User Info -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-user-circle text-info"></i> Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3"
                             style="width: 50px; height: 50px;">
                            <span class="h5 text-white mb-0">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 py-2 d-flex justify-content-between">
                            <span class="text-muted">Telepon</span>
                            <strong>{{ Auth::user()->phone ?? '-' }}</strong>
                        </div>
                        <div class="list-group-item px-0 py-2 d-flex justify-content-between">
                            <span class="text-muted">Role</span>
                            <span class="badge bg-{{ Auth::user()->role === 'admin' ? 'danger' : 'primary' }}">
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                        <div class="list-group-item px-0 py-2 d-flex justify-content-between">
                            <span class="text-muted">Bergabung</span>
                            <strong>{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d/m/Y') }}</strong>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="mb-3"><i class="fas fa-lightbulb text-warning"></i> Tips Cepat</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Periksa stok sebelum menyewa</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Kembalikan tepat waktu untuk menghindari denda</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Hubungi admin jika ada masalah</small>
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Baca syarat dan ketentuan dengan teliti</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }

    /* Bootstrap 5 replacement untuk border-left-* */
    .stat-card { position: relative; }
    .stat-card::before{
        content:"";
        position:absolute;
        left:0; top:0; bottom:0;
        width:4px;
        border-radius: .35rem 0 0 .35rem;
    }
    .stat-primary::before { background: #0d6efd; }
    .stat-success::before { background: #198754; }
    .stat-warning::before { background: #ffc107; }
    .stat-info::before { background: #0dcaf0; }

    .opacity-50 { opacity: 0.5; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh stats every 60 seconds
        setInterval(function() {
            fetch('/api/dashboard-stats')
                .then(response => response.json())
                .then(data => console.log('Stats updated:', data))
                .catch(error => console.log('Error updating stats:', error));
        }, 60000);

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>
@endpush