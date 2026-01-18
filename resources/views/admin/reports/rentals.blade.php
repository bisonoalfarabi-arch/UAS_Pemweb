@extends('layouts.admin')

@section('title', 'Laporan Penyewaan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Laporan Penyewaan</h3>
        <div class="text-muted small">Rekap transaksi penyewaan berdasarkan filter.</div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="window.print()">
            <i class="fas fa-print me-1"></i> Cetak
        </button>
        <a href="{{ route('admin.reports') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

{{-- Filter --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.rentals') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="pending"   {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved"  {{ request('status')=='approved' ? 'selected' : '' }}>Approved</option>
                    <option value="active"    {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="rejected"  {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Cari</label>
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                           placeholder="Nama user/peralatan" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.reports.rentals') }}">
                        <i class="fas fa-rotate"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Summary --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Total Transaksi</div>
                <div class="h4 mb-0">{{ $rentals->total() ?? $rentals->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Total Pendapatan (Filtered)</div>
                <div class="h4 mb-0 text-success">
                    Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Status Terbanyak</div>
                <div class="h4 mb-0">
                    {{ strtoupper($topStatus ?? '-') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong>Data Penyewaan</strong>
        <span class="text-muted small">
            Menampilkan {{ $rentals->firstItem() ?? 1 }} - {{ $rentals->lastItem() ?? ($rentals->count() ?? 0) }}
            dari {{ $rentals->total() ?? ($rentals->count() ?? 0) }}
        </span>
    </div>

    <div class="card-body p-0">
        @if(($rentals->count() ?? 0) > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Kode</th>
                        <th>Penyewa</th>
                        <th>Peralatan</th>
                        <th>Tanggal Sewa</th>
                        <th>Tanggal Kembali</th>
                        <th class="text-center">Durasi</th>
                        <th class="text-end">Total Harga</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rentals as $rental)
                    <tr>
                        <td>{{ $loop->iteration + (($rentals->currentPage() - 1) * $rentals->perPage()) }}</td>
                        <td>
                            <span class="badge bg-secondary">#{{ str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $rental->user->name ?? '-' }}</div>
                            <div class="text-muted small">{{ $rental->user->email ?? '' }}</div>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $rental->equipment->name ?? '-' }}</div>
                            <div class="text-muted small">
                                Rp {{ number_format($rental->equipment->price_per_day ?? 0, 0, ',', '.') }}/hari
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($rental->return_date)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $rental->total_days }} hari</span>
                        </td>
                        <td class="text-end fw-bold text-success">
                            Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'approved' => 'primary',
                                    'active' => 'info',
                                    'completed' => 'success',
                                    'cancelled' => 'danger',
                                    'rejected' => 'secondary'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$rental->status] ?? 'secondary' }}">
                                {{ strtoupper($rental->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="7" class="text-end">TOTAL</th>
                        <th class="text-end text-success">
                            Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                        </th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="p-3 d-flex justify-content-end">
            {{ method_exists($rentals, 'links') ? $rentals->withQueryString()->links() : '' }}
        </div>
        @else
        <div class="p-5 text-center text-muted">
            <i class="fas fa-clipboard-list fa-3x mb-3 opacity-25"></i>
            <div>Tidak ada data penyewaan untuk filter ini.</div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
@media print {
    .btn, .input-group, form, .admin-sidebar, .alert { display: none !important; }
    .col-md-9, .col-lg-10 { width: 100% !important; }
}
</style>
@endpush
@endsection
