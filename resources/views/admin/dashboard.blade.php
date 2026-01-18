@extends('layouts.app')

@section('title', 'Dashboard Admin - FotoRental')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Dashboard Admin</h1>
        <div>
            <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Peralatan
            </a>
            <a href="{{ route('admin.rentals.index') }}" class="btn btn-success">
                <i class="fas fa-list"></i> Kelola Penyewaan
            </a>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['totalUsers'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.users.index') }}" class="text-primary small">
                            <i class="fas fa-eye"></i> Lihat Semua
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Penyewaan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['totalRentals'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-camera fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.rentals.index') }}" class="text-success small">
                            <i class="fas fa-cog"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Peralatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['totalEquipment'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.equipment.index') }}" class="text-info small">
                            <i class="fas fa-edit"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.reports.revenue') }}" class="text-warning small">
                            <i class="fas fa-chart-bar"></i> Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i> Tambah Peralatan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.equipment.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-edit"></i> Edit Peralatan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.rentals.index') }}" class="btn btn-success btn-block">
                                <i class="fas fa-list"></i> Kelola Penyewaan
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-users-cog"></i> Kelola User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Rentals Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Penyewaan Terbaru</h6>
            <a href="{{ route('admin.rentals.index') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-list"></i> Lihat Semua
            </a>
        </div>
        <div class="card-body">
            @if($recentRentals->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Penyewa</th>
                                <th>Peralatan</th>
                                <th>Tanggal Sewa</th>
                                <th>Tanggal Kembali</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th width="160">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRentals as $rental)
                                <tr>
                                    <td>{{ $rental->id }}</td>
                                    <td>{{ $rental->user->name ?? '-' }}</td>
                                    <td>{{ $rental->equipment->name ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($rental->return_date)->format('d/m/Y') }}</td>
                                    <td>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{
                                            $rental->status == 'completed' ? 'success' :
                                            ($rental->status == 'active' ? 'primary' :
                                            ($rental->status == 'pending' ? 'warning' : 'danger'))
                                        }}">
                                            {{ $rental->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($rental->status == 'pending')
                                            {{-- Approve (PUT) --}}
                                            <form action="{{ route('admin.rentals.approve', $rental) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success" title="Setujui"
                                                        onclick="return confirm('Setujui penyewaan ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                            {{-- Reject (PUT) --}}
                                            <form action="{{ route('admin.rentals.reject', $rental) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Tolak"
                                                        onclick="return confirm('Tolak penyewaan ini?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted mb-0">Belum ada penyewaan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Equipment Table -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Peralatan Terbaru</h6>
            <a href="{{ route('admin.equipment.index') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-list"></i> Lihat Semua
            </a>
        </div>
        <div class="card-body">
            @php
                $recentEquipment = \App\Models\Equipment::latest()->take(5)->get();
            @endphp

            @if($recentEquipment->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga/Hari</th>
                                <th>Stok</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentEquipment as $equipment)
                                <tr>
                                    <td>{{ $equipment->name }}</td>
                                    <td>{{ $equipment->category->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $equipment->stock > 0 ? 'success' : 'danger' }}">
                                            {{ $equipment->stock }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.equipment.edit', $equipment) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.equipment.destroy', $equipment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="return confirm('Hapus peralatan ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted mb-0">Belum ada peralatan.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection