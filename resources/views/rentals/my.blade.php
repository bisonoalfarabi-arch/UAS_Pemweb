{{-- resources/views/rentals/my.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Penyewaan Saya - FotoRental')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 text-primary">
                <i class="fas fa-history me-2"></i>Riwayat Penyewaan Saya
            </h1>
            <p class="text-muted">Lihat semua riwayat penyewaan peralatan fotografi Anda</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Sewa Baru
            </a>
        </div>
    </div>

    <!-- Filter Status -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">Filter Status</label>
                    <select class="form-select" id="statusFilter" onchange="filterByStatus()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="dateRange" class="form-label">Rentang Tanggal</label>
                    <div class="input-group">
                        <input type="date" class="form-control" id="startDate" value="{{ request('start_date') }}">
                        <span class="input-group-text">s/d</span>
                        <input type="date" class="form-control" id="endDate" value="{{ request('end_date') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="applyFilters()">
                            <i class="fas fa-filter me-2"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('rentals.my') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-2"></i>Reset Filter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Sewaan</h5>
                    <h2 class="mb-0">{{ $stats['totalRentals'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Aktif</h5>
                    <h2 class="mb-0">{{ $stats['activeRentals'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <h5 class="card-title">Menunggu</h5>
                    <h2 class="mb-0">{{ $stats['pendingRentals'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Pengeluaran</h5>
                    <h4 class="mb-0">Rp {{ number_format($stats['totalSpent'], 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Rentals Table -->
    <div class="card">
        <div class="card-body">
            @if($rentals->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Peralatan</th>
                                <th>Tanggal Sewa</th>
                                <th>Tanggal Kembali</th>
                                <th>Durasi</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentals as $rental)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                         <img src="{{ asset('storage/'.$rental->equipment->image) }}"
                                            alt="{{ $rental->equipment->name }}"
                                            class="rounded"
                                            style="width:40px;height:40px;object-fit:cover;">
                                        <div>
                                            <strong>{{ $rental->equipment->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $rental->equipment->category->name ?? 'Tidak ada kategori' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ $rental->rental_date->translatedFormat('d M Y') }}
                                    <br>
                                    <small class="text-muted">{{ $rental->rental_date->format('H:i') }}</small>
                                </td>
                                <td>
                                    {{ $rental->return_date->translatedFormat('d M Y') }}
                                    <br>
                                    <small class="text-muted">{{ $rental->return_date->format('H:i') }}</small>
                                </td>
                                <td>
                                    {{ $rental->total_days }} hari
                                    <br>
                                    @if($rental->status == 'active' && now() > $rental->return_date)
                                        <span class="badge bg-danger">Terlambat: {{ now()->diffInDays($rental->return_date) }} hari</span>
                                    @endif
                                </td>
                                <td>
                                    1 unit
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $rental->status_badge }} py-2 px-3">
                                        <i class="fas fa-{{ $rental->status_icon }} me-1"></i>
                                        {{ $rental->status_text }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" data-bs-target="#detailModal{{ $rental->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        @if($rental->status == 'pending')
                                            <form action="{{ route('rentals.cancel', $rental->id) }}" method="POST" 
                                                  class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan penyewaan ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($rental->status == 'active' && now() <= $rental->return_date)
                                            <a href="#" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-redo"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Detail Modal -->
                            <div class="modal fade" id="detailModal{{ $rental->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Penyewaan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="{{ $rental->equipment->image_url ? Storage::url($rental->equipment->image_url) : asset('images/default.jpg') }}" 
                                                         alt="{{ $rental->equipment->name }}" 
                                                         class="img-fluid rounded mb-3">
                                                </div>
                                                <div class="col-md-8">
                                                    <h5>{{ $rental->equipment->name }}</h5>
                                                    <p class="text-muted">{{ $rental->equipment->category->name ?? 'Tidak ada kategori' }}</p>
                                                    
                                                    <div class="row mt-3">
                                                        <div class="col-6">
                                                            <p class="mb-1"><strong>Tanggal Sewa:</strong></p>
                                                            <p>{{ $rental->rental_date->translatedFormat('l, d F Y H:i') }}</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-1"><strong>Tanggal Kembali:</strong></p>
                                                            <p>{{ $rental->return_date->translatedFormat('l, d F Y H:i') }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="mb-1"><strong>Lama Sewa:</strong></p>
                                                            <p>{{ $rental->total_days }} hari</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-1"><strong>Harga per Hari:</strong></p>
                                                            <p>Rp {{ number_format($rental->equipment->price_per_day, 0, ',', '.') }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="alert alert-info">
                                                        <div class="d-flex justify-content-between">
                                                            <span><strong>Total Biaya:</strong></span>
                                                            <span><strong>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</strong></span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <p class="mb-1"><strong>Status:</strong></p>
                                                        <span class="badge bg-{{ $rental->status_badge }} py-2 px-3">
                                                            <i class="fas fa-{{ $rental->status_icon }} me-1"></i>
                                                            {{ $rental->status_text }}
                                                        </span>
                                                        
                                                        @if($rental->status == 'active' && now() > $rental->return_date)
                                                            <div class="alert alert-danger mt-2">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                                Penyewaan terlambat {{ now()->diffInDays($rental->return_date) }} hari
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            @if($rental->status == 'pending')
                                                <form action="{{ route('rentals.cancel', $rental->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-danger" 
                                                            onclick="return confirm('Yakin ingin membatalkan penyewaan ini?')">
                                                        <i class="fas fa-times me-2"></i>Batalkan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $rentals->firstItem() }} - {{ $rentals->lastItem() }} dari {{ $rentals->total() }} data
                    </div>
                    <div>
                        {{ $rentals->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum ada riwayat penyewaan</h4>
                    <p class="text-muted mb-4">Mulai sewa peralatan fotografi favorit Anda!</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-camera me-2"></i>Sewa Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Legend -->
    <div class="card mt-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Keterangan Status</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <span class="badge bg-warning py-2 px-3 me-2"></span>
                    <span>Menunggu - Menunggu konfirmasi</span>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="badge bg-success py-2 px-3 me-2"></span>
                    <span>Aktif - Sedang disewa</span>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="badge bg-info py-2 px-3 me-2"></span>
                    <span>Selesai - Telah dikembalikan</span>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="badge bg-secondary py-2 px-3 me-2"></span>
                    <span>Dibatalkan - Sewa dibatalkan</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }
    .badge {
        font-size: 0.85rem;
        font-weight: normal;
    }
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function filterByStatus() {
        const status = document.getElementById('statusFilter').value;
        if (status) {
            window.location.href = '{{ route("rentals.my") }}?status=' + status;
        }
    }
    
    function applyFilters() {
        const status = document.getElementById('statusFilter').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        let url = '{{ route("rentals.my") }}?';
        let params = [];
        
        if (status) params.push('status=' + status);
        if (startDate) params.push('start_date=' + startDate);
        if (endDate) params.push('end_date=' + endDate);
        
        if (params.length > 0) {
            window.location.href = url + params.join('&');
        }
    }
    
    // Auto-set end date min based on start date
    document.getElementById('startDate').addEventListener('change', function() {
        document.getElementById('endDate').min = this.value;
    });
    
    // Auto-set start date max based on end date
    document.getElementById('endDate').addEventListener('change', function() {
        document.getElementById('startDate').max = this.value;
    });
    
    // Initialize date limits
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('startDate').max = today;
        document.getElementById('endDate').max = today;
    });
</script>
@endpush