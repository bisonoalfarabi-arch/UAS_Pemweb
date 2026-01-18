@extends('layouts.app')

@section('title', 'Laporan Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Laporan Sistem</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Laporan Penyewaan</h5>
                    <p class="card-text text-muted mb-3">Rekap seluruh transaksi penyewaan</p>
                    <a href="{{ route('admin.reports.rentals') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-clipboard-list"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Laporan Pendapatan</h5>
                    <p class="card-text text-muted mb-3">Total pendapatan dari penyewaan</p>
                    <a href="{{ route('admin.reports.revenue') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-coins"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
