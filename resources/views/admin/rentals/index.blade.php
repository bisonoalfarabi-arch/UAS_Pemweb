@extends('layouts.app')

@section('title', 'Kelola Penyewaan - Admin')

@section('content')
@php
    // Hitung global (bukan cuma per halaman)
    $pendingCount   = \App\Models\Rental::where('status', 'pending')->count();
    $activeCount    = \App\Models\Rental::where('status', 'active')->count();
    $completedCount = \App\Models\Rental::where('status', 'completed')->count();
    $cancelledCount = \App\Models\Rental::where('status', 'cancelled')->count();

    // Total pendapatan global (yang completed saja)
    $totalRevenueAll = \App\Models\Rental::where('status', 'completed')->sum('total_price');
@endphp

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Kelola Penyewaan</h1>
        <div class="no-print">
            <button class="btn btn-info" onclick="printTable(event)">
                <i class="fas fa-print"></i> Cetak
            </button>
        </div>
    </div>

    <!-- Status Summary (GLOBAL) -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-uppercase small">Pending</div>
                            <div class="h5 mb-0">{{ $pendingCount }}</div>
                        </div>
                        <div class="align-self-center"><i class="fas fa-clock fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white shadow">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-uppercase small">Active</div>
                            <div class="h5 mb-0">{{ $activeCount }}</div>
                        </div>
                        <div class="align-self-center"><i class="fas fa-play-circle fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-uppercase small">Completed</div>
                            <div class="h5 mb-0">{{ $completedCount }}</div>
                        </div>
                        <div class="align-self-center"><i class="fas fa-check-circle fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-uppercase small">Cancelled</div>
                            <div class="h5 mb-0">{{ $cancelledCount }}</div>
                        </div>
                        <div class="align-self-center"><i class="fas fa-times-circle fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show no-print" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <!-- Filter Form -->
    <div class="card shadow mb-4 no-print">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Penyewaan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.rentals.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Dari Tanggal</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                   value="{{ request('start_date') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">Sampai Tanggal</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                   value="{{ request('end_date') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Cari</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" name="search"
                                       value="{{ request('search') }}" placeholder="Nama user/peralatan">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('admin.rentals.index') }}" class="btn btn-secondary"><i class="fas fa-redo"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Rentals Table -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Penyewaan</h6>
            <div class="text-muted">
                Total: {{ $rentals->total() }} penyewaan
            </div>
        </div>

        <div class="card-body">
            @if($rentals->count() > 0)
                <div class="table-responsive" id="printableTable">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th width="50">#</th>
                                <th width="100">Kode</th>
                                <th>Penyewa</th>
                                <th>Peralatan</th>
                                <th>Tanggal Sewa</th>
                                <th>Tanggal Kembali</th>
                                <th>Durasi</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th width="170" class="no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentals as $rental)
                                <tr>
                                    <td>{{ $loop->iteration + ($rentals->perPage() * ($rentals->currentPage() - 1)) }}</td>
                                    <td><span class="badge badge-secondary">#{{ str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                    <td>
                                        <div class="font-weight-bold">{{ $rental->user->name }}</div>
                                        <small class="text-muted">{{ $rental->user->email }}</small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $rental->equipment->name }}</div>
                                        <small class="text-muted">Rp {{ number_format($rental->equipment->price_per_day, 0, ',', '.') }}/hari</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($rental->return_date)->format('d/m/Y') }}</td>
                                    <td><span class="badge badge-info">{{ $rental->total_days }} hari</span></td>
                                    <td>
                                        <span class="font-weight-bold text-success">
                                            Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'active' => 'primary',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                'rejected' => 'secondary'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $statusColors[$rental->status] ?? 'secondary' }}">
                                            {{ strtoupper($rental->status) }}
                                        </span>
                                    </td>

                                    <td class="no-print">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.rentals.show', $rental->id) }}"
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($rental->status == 'pending')
                                                <form action="{{ route('admin.rentals.approve', $rental->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success" title="Setujui"
                                                            onclick="return confirm('Setujui penyewaan ini?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.rentals.reject', $rental->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Tolak"
                                                            onclick="return confirm('Tolak penyewaan ini?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($rental->status == 'active')
                                                <form action="{{ route('admin.rentals.complete', $rental->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success" title="Selesaikan"
                                                            onclick="return confirm('Selesaikan penyewaan ini?')">
                                                        <i class="fas fa-flag-checkered"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.rentals.destroy', $rental->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                        onclick="return confirm('Hapus penyewaan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="7" class="text-right font-weight-bold">TOTAL PENDAPATAN (COMPLETED):</td>
                                <td class="font-weight-bold text-success">
                                    Rp {{ number_format($totalRevenueAll, 0, ',', '.') }}
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3 no-print">
                    <div class="text-muted">
                        Menampilkan {{ $rentals->firstItem() }} - {{ $rentals->lastItem() }} dari {{ $rentals->total() }} penyewaan
                    </div>
                    <div>
                        {{ $rentals->withQueryString()->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3"><i class="fas fa-clipboard-list fa-4x text-muted"></i></div>
                    <h5 class="text-muted">Belum ada penyewaan</h5>
                    <p class="text-muted">Tidak ada data penyewaan yang ditemukan.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-hover tbody tr:hover { background-color: rgba(0, 123, 255, 0.05); }
    .badge { font-size: 0.85em; padding: 0.4em 0.8em; }
    .btn-group .btn { margin-right: 2px; margin-bottom: 2px; }

    @media print {
        .no-print { display: none !important; }
        .card { border: none; box-shadow: none; }
        .table { border: 1px solid #dee2e6; }
        .table th { background-color: #f8f9fa !important; border: 1px solid #dee2e6; color: #000 !important; }
    }
</style>
@endpush

@push('scripts')
<script>
    function printTable(e) {
        if (e) e.preventDefault();
        window.print();
    }

    // Date validation (aman kalau element ada)
    document.addEventListener('DOMContentLoaded', function () {
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');

        if (startDate && endDate) {
            startDate.addEventListener('change', function () {
                if (this.value && endDate.value && this.value > endDate.value) {
                    alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                    this.value = '';
                }
            });

            endDate.addEventListener('change', function () {
                if (this.value && startDate.value && this.value < startDate.value) {
                    alert('Tanggal akhir tidak boleh lebih kecil dari tanggal mulai');
                    this.value = '';
                }
            });
        }
    });
</script>
@endpush