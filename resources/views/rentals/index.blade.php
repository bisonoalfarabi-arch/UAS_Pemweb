@extends('layouts.app')

@section('title', 'Riwayat Sewa - FotoRental')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-history me-2"></i>Riwayat Penyewaan</h1>
        <div>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus me-2"></i>Sewa Baru
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    @if($rentals->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Equipment</th>
                                <th>Tanggal Sewa</th>
                                <th>Tanggal Kembali</th>
                                <th>Durasi</th>
                                <th>Total Biaya</th>
                                <th>Status</th>
                                <th>Tanggal Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentals as $rental)
                                <tr>
                                    <td>
                                        <strong>{{ $rental->equipment->name }}</strong>
                                    </td>
                                    <td>{{ $rental->rental_date->format('d M Y') }}</td>
                                    <td>{{ $rental->return_date->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $rental->total_days }} hari</span>
                                    </td>
                                    <td>
                                        <strong>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $rental->status_badge }}">
                                            {{ $rental->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $rental->created_at->format('d M Y H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($rental->canBeCancelled())
                                            <form action="{{ route('rentals.cancel', $rental->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Batalkan penyewaan ini?')">
                                                    <i class="fas fa-times"></i> Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $rentals->links() }}
        </div>

        <!-- Statistics -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4>{{ $rentals->total() }}</h4>
                        <p class="mb-0">Total Sewaan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4>{{ $activeRentals }}</h4>
                        <p class="mb-0">Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body text-center">
                        <h4>{{ $pendingRentals }}</h4>
                        <p class="mb-0">Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h4>Rp {{ number_format($totalSpent, 0, ',', '.') }}</h4>
                        <p class="mb-0">Total Pengeluaran</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
            <h3 class="text-muted">Belum ada riwayat penyewaan</h3>
            <p class="text-muted mb-4">Mulai sewa equipment fotografi favorit Anda</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-camera me-2"></i>Jelajahi Katalog
            </a>
        </div>
    @endif
</div>
@endsection