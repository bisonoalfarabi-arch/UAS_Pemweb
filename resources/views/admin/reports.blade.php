@extends('layouts.app')

@section('title', 'Laporan - Admin FotoRental')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0"><i class="fas fa-chart-bar"></i> Laporan</h3>
            <small class="text-muted">Pilih jenis laporan yang ingin dilihat</small>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="mb-2"><i class="fas fa-receipt text-primary"></i> Laporan Penyewaan</h5>
                    <p class="text-muted mb-3">Filter berdasarkan tanggal, status, dan pencarian user/peralatan.</p>
                    <a href="{{ route('admin.reports.rentals') }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="mb-2"><i class="fas fa-money-bill-wave text-success"></i> Laporan Pendapatan</h5>
                    <p class="text-muted mb-3">Lihat pendapatan per hari/bulan berdasarkan transaksi selesai.</p>
                    <a href="{{ route('admin.reports.revenue') }}" class="btn btn-success">
                        <i class="fas fa-eye"></i> Buka
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
