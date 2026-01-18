@extends('layouts.admin')

@section('title', 'Laporan Pendapatan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Laporan Pendapatan</h3>
        <div class="text-muted small">Rekap pendapatan penyewaan (umumnya dari status completed/approved/active sesuai logika controller).</div>
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
        <form method="GET" action="{{ route('admin.reports.revenue') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Group By</label>
                <select name="group" class="form-select">
                    <option value="day"   {{ request('group','day')=='day' ? 'selected' : '' }}>Harian</option>
                    <option value="month" {{ request('group')=='month' ? 'selected' : '' }}>Bulanan</option>
                    <option value="year"  {{ request('group')=='year' ? 'selected' : '' }}>Tahunan</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-success w-100" type="submit">
                    <i class="fas fa-filter me-1"></i> Terapkan
                </button>
                <a href="{{ route('admin.reports') }}" class="btn btn-secondary">
                    <i class="fas fa-rotate"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Total Pendapatan</div>
                <div class="h4 mb-0 text-success">
                    Rp {{ number_format($grandTotal ?? 0, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Total Transaksi</div>
                <div class="h4 mb-0">{{ $totalTransactions ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Rata-rata / Transaksi</div>
                <div class="h4 mb-0">
                    Rp {{ number_format($avgPerTransaction ?? 0, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong>Rekap Pendapatan</strong>
        <span class="text-muted small">Group: {{ strtoupper(request('group','day')) }}</span>
    </div>

    <div class="card-body p-0">
        @if(($rows ?? collect())->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Periode</th>
                        <th class="text-center">Jumlah Transaksi</th>
                        <th class="text-end">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                    <tr>
                        <td class="fw-semibold">{{ $row->period }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary">{{ $row->transactions }}</span>
                        </td>
                        <td class="text-end fw-bold text-success">
                            Rp {{ number_format($row->revenue, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th class="text-end">TOTAL</th>
                        <th class="text-center">
                            <span class="badge bg-dark">{{ $totalTransactions ?? 0 }}</span>
                        </th>
                        <th class="text-end text-success">
                            Rp {{ number_format($grandTotal ?? 0, 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="p-5 text-center text-muted">
            <i class="fas fa-chart-line fa-3x mb-3 opacity-25"></i>
            <div>Tidak ada data pendapatan untuk rentang tanggal ini.</div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
@media print {
    .btn, form, .admin-sidebar, .alert { display: none !important; }
    .col-md-9, .col-lg-10 { width: 100% !important; }
}
</style>
@endpush
@endsection
