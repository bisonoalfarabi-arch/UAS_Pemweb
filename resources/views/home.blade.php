@extends('layouts.app')

@section('title', 'FotoRental - Penyewaan Alat Fotografi')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Sewa Alat Fotografi Berkualitas</h1>
            <p class="lead mb-4">Temukan berbagai peralatan fotografi terbaik untuk kebutuhan kreatif Anda dengan harga terjangkau</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg me-2">Lihat Katalog</a>
            <a href="#about" class="btn btn-outline-light btn-lg">Tentang Kami</a>
        </div>
    </section>

    <!-- Featured Equipment -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title mb-5">Peralatan Terpopuler</h2>
            <div class="row">
                @forelse($featuredEquipment as $equipment)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="position-relative">
                            <img
                                src="{{ $equipment->image ? asset('storage/'.$equipment->image) : asset('images/default.jpg') }}"
                                class="card-img-top equipment-image"
                                alt="{{ $equipment->name }}"
                                style="height: 200px; object-fit: cover;">
                                <span class="badge bg-{{ $equipment->stock > 0 ? 'success' : 'danger' }} position-absolute top-0 end-0 m-2">
                                {{ $equipment->stock > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $equipment->name }}</h5>
                            <p class="card-text text-muted small">{{ $equipment->category->name }}</p>
                            <p class="card-text grow">
                                {{ Str::limit($equipment->description, 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="price-tag">Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}/hari</span>
                                <a href="{{ route('catalog.index', ['search' => $equipment->name]) }}" 
                                   class="btn btn-outline-primary btn-sm">Sewa</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Tidak ada peralatan yang tersedia saat ini.
                    </div>
                </div>
                @endforelse
            </div>
            @if($featuredEquipment->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ route('catalog.index') }}" class="btn btn-primary">Lihat Semua Peralatan</a>
            </div>
            @endif
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5" id="about">
        <div class="container">
            <h2 class="text-center section-title mb-5">Tentang FotoRental</h2>
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h3>Solusi Penyewaan Alat Fotografi Terpercaya</h3>
                    <p class="lead">Kami menyediakan berbagai peralatan fotografi berkualitas tinggi dengan harga terjangkau untuk mendukung kreativitas Anda.</p>
                    <p>Dengan pengalaman lebih dari 5 tahun di industri fotografi, kami memahami kebutuhan fotografer baik pemula maupun profesional. Setiap equipment kami rawat dengan baik dan selalu dalam kondisi prima.</p>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Peralatan Berkualitas</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Harga Terjangkau</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Support 24/7</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Garansi Equipment</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="https://images.unsplash.com/photo-1554048612-b6a482bc67e5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                                 alt="About Us" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title mb-5">Kategori Peralatan</h2>
            <div class="row">
                @forelse($categories as $category)
                <div class="col-md-3 col-6 mb-4">
                    <div class="card category-card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-camera fa-2x text-primary mb-3"></i>
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text small text-muted">{{ Str::limit($category->description, 80) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Tidak ada kategori yang tersedia.
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5" id="contact">
        <div class="container">
            <h2 class="text-center section-title mb-5">Hubungi Kami</h2>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <h4>Informasi Kontak</h4>
                    <div class="contact-info">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-map-marker-alt text-primary me-3"></i>
                            <div>
                                <strong>Alamat</strong>
                                <p class="mb-0">Jl. Fotografi No. 123, Bandung, Jawa Barat</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-phone text-primary me-3"></i>
                            <div>
                                <strong>Telepon</strong>
                                <p class="mb-0">+62 812 3456 7890</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <div>
                                <strong>Email</strong>
                                <p class="mb-0">info@fotorental.com</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-clock text-primary me-3"></i>
                            <div>
                                <strong>Jam Operasional</strong>
                                <p class="mb-0">Senin - Minggu, 08:00 - 22:00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4>Kirim Pesan</h4>
                    <form id="contactForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Nama Lengkap" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="email" class="form-control" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Subjek" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="5" placeholder="Pesan Anda" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Pesan Anda telah terkirim! Kami akan membalas dalam 1x24 jam.');
        this.reset();
    });
</script>
@endpush