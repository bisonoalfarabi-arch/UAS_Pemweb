@extends('layouts.app')

@section('title', 'Tentang Kami - FotoRental')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 mb-3">Tentang <span class="text-primary">FotoRental</span></h1>
                <p class="lead text-muted">Sewa peralatan fotografi profesional dengan mudah dan terjangkau</p>
            </div>

            <!-- Company Overview -->
            <div class="card shadow-sm mb-5">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="mb-4">Siapa Kami?</h2>
                            <p class="text-muted mb-4">
                                FotoRental adalah platform penyewaan peralatan fotografi terpercaya yang didirikan pada tahun 2020. 
                                Kami berkomitmen untuk menyediakan peralatan fotografi berkualitas tinggi dengan harga terjangkau 
                                bagi para fotografer, videografer, dan content creator.
                            </p>
                            <p class="text-muted">
                                Dengan lebih dari 100+ peralatan yang tersedia, kami telah melayani ribuan pelanggan 
                                di seluruh Indonesia dan terus berinovasi untuk memberikan pengalaman terbaik.
                            </p>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="https://images.unsplash.com/photo-1554048612-b6a482bc67e5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                                 alt="About Us" class="img-fluid rounded shadow">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mission & Vision -->
            <div class="row mb-5">
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-left-primary">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-bullseye fa-2x text-white"></i>
                                </div>
                            </div>
                            <h3 class="text-center mb-3">Misi Kami</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Menyediakan peralatan fotografi terbaik</li>
                                <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Memberikan harga yang kompetitif</li>
                                <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Memastikan kepuasan pelanggan</li>
                                <li><i class="fas fa-check text-success mr-2"></i> Mendukung kreativitas fotografer Indonesia</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-left-success">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-eye fa-2x text-white"></i>
                                </div>
                            </div>
                            <h3 class="text-center mb-3">Visi Kami</h3>
                            <p class="text-muted">
                                Menjadi platform penyewaan peralatan fotografi nomor satu di Indonesia yang dikenal 
                                dengan kualitas peralatan, pelayanan terbaik, dan inovasi teknologi.
                            </p>
                            <p class="text-muted">
                                Kami bercita-cita untuk membuat setiap orang dapat mengakses peralatan fotografi 
                                profesional tanpa hambatan biaya.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-white py-4">
                    <h2 class="text-center mb-0">Mengapa Memilih FotoRental?</h2>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="mb-3">
                                <div class="rounded-circle bg-info d-inline-flex align-items-center justify-content-center" 
                                     style="width: 70px; height: 70px;">
                                    <i class="fas fa-shield-alt fa-2x text-white"></i>
                                </div>
                            </div>
                            <h5>Terjamin & Terpercaya</h5>
                            <p class="text-muted small">Semua peralatan melalui quality check sebelum disewakan</p>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="mb-3">
                                <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center" 
                                     style="width: 70px; height: 70px;">
                                    <i class="fas fa-money-bill-wave fa-2x text-white"></i>
                                </div>
                            </div>
                            <h5>Harga Terjangkau</h5>
                            <p class="text-muted small">Harga sewa yang kompetitif dengan kualitas terbaik</p>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="mb-3">
                                <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center" 
                                     style="width: 70px; height: 70px;">
                                    <i class="fas fa-headset fa-2x text-white"></i>
                                </div>
                            </div>
                            <h5>Support 24/7</h5>
                            <p class="text-muted small">Tim support siap membantu kapan saja Anda butuhkan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center">
                <div class="card bg-primary text-white shadow-lg">
                    <div class="card-body py-5">
                        <h2 class="mb-3">Siap Mulai Menyewa?</h2>
                        <p class="mb-4">Jelajahi koleksi peralatan fotografi terbaik kami</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-light btn-lg px-5">
                            <i class="fas fa-camera mr-2"></i> Lihat Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection