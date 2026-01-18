@extends('layouts.app')

@section('title', 'Kelola Peralatan - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Kelola Peralatan</h1>
        <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Peralatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $equipment->total() }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $availableEquipment }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Stok Sedikit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lowStockEquipment }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-left-danger shadow-sm h-100 py-2">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Habis</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $outOfStockEquipment }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
        </div>
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.equipment.index') }}" class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="search"
                           value="{{ request('search') }}" placeholder="Cari nama...">
                </div>

                <div class="col-md-2">
                    <select class="form-control form-control-sm" name="category">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select class="form-control form-control-sm" name="stock_status">
                        <option value="">Semua Stok</option>
                        <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Stok Sedikit</option>
                        <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select class="form-control form-control-sm" name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary btn-sm" title="Reset">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Equipment Table -->
    <div class="card shadow-sm">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Peralatan</h6>
            <span class="badge badge-light">
                {{ $equipment->firstItem() }}-{{ $equipment->lastItem() }} dari {{ $equipment->total() }}
            </span>
        </div>

        <div class="card-body p-0">
            @if($equipment->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th width="80">Gambar</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th class="text-center">Harga/Hari</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($equipment as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration + ($equipment->perPage() * ($equipment->currentPage() - 1)) }}
                                    </td>

                                    <td>
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}"
                                                 alt="{{ $item->name }}"
                                                 class="img-fluid rounded"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                 style="width: 60px; height: 60px;">
                                                <i class="fas fa-camera text-muted"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="font-weight-bold">{{ $item->name }}</div>
                                        <small class="text-muted text-truncate d-block" style="max-width: 200px;">
                                            {{ \Illuminate\Support\Str::limit($item->description, 50) }}
                                        </small>
                                    </td>

                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $item->category->name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="font-weight-bold text-primary">
                                            Rp {{ number_format($item->price_per_day, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="font-weight-bold">{{ $item->stock }}</span>
                                    </td>

                                    <td class="text-center">
                                        @if($item->stock > 5)
                                            <span class="badge badge-success">Tersedia</span>
                                        @elseif($item->stock > 0)
                                            <span class="badge badge-warning">Stok Sedikit</span>
                                        @else
                                            <span class="badge badge-danger">Habis</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('catalog.show', $item->id) }}"
                                               class="btn btn-info"
                                               title="Lihat"
                                               target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.equipment.edit', $item->id) }}"
                                               class="btn btn-warning"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <button type="button"
                                                    class="btn btn-danger"
                                                    title="Hapus"
                                                    onclick="confirmDelete(event, {{ $item->id }}, '{{ addslashes($item->name) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <form id="delete-form-{{ $item->id }}"
                                              action="{{ route('admin.equipment.destroy', $item->id) }}"
                                              method="POST"
                                              style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div class="text-muted small">
                        Menampilkan {{ $equipment->firstItem() }} - {{ $equipment->lastItem() }} dari {{ $equipment->total() }} item
                    </div>
                    <nav aria-label="Page navigation">
                        {{ $equipment->withQueryString()->onEachSide(1)->links('vendor.pagination.bootstrap-4-sm') }}
                    </nav>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-box-open fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Belum ada peralatan</h5>
                    <p class="text-muted">Mulai dengan menambahkan peralatan baru.</p>
                    <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Peralatan
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3 d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Peralatan Baru
        </a>
        <a href="#" class="btn btn-success btn-sm" onclick="exportTable(event)">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="#" class="btn btn-danger btn-sm" onclick="printTable(event)">
            <i class="fas fa-print"></i> Print
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th, .table td { vertical-align: middle; padding: 0.75rem; font-size: 0.9rem; }
    .table thead th { border-bottom: 2px solid #e3e6f0; background-color: #f8f9fc; color: #5a5c69; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
    .table tbody tr:hover { background-color: rgba(0, 123, 255, 0.05); }
    .badge { font-size: 0.75rem; padding: 0.25rem 0.5rem; font-weight: 500; }
    .btn-group-sm > .btn { padding: 0.25rem 0.5rem; font-size: 0.75rem; border-radius: 0.2rem; }
    .pagination { margin-bottom: 0; }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(e, id, name) {
        e.preventDefault();
        if (confirm(`Apakah Anda yakin ingin menghapus peralatan "${name}"?`)) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    }

    function printTable(e) {
        e.preventDefault();

        const tableWrap = document.querySelector('.table-responsive');
        if (!tableWrap) return alert('Tidak ada data untuk di-print.');

        const printContent = tableWrap.innerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = `
            <html>
                <head>
                    <title>Daftar Peralatan - FotoRental</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 16px; }
                        table { width: 100%; border-collapse: collapse; }
                        th { background-color: #f2f2f2; text-align: left; padding: 8px; }
                        td { padding: 8px; border-bottom: 1px solid #ddd; }
                        .text-center { text-align: center; }
                        @media print { @page { size: landscape; } }
                    </style>
                </head>
                <body>
                    <h2>Daftar Peralatan - FotoRental</h2>
                    <p>Tanggal: ${new Date().toLocaleDateString('id-ID')}</p>
                    ${printContent}
                </body>
            </html>
        `;

        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }

    function exportTable(e) {
        e.preventDefault();
        alert('Fitur export Excel akan segera tersedia.');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput && !searchInput.value) searchInput.focus();
    });
</script>
@endpush