@extends('layouts.app')

@section('title', 'Kontak - FotoRental')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 mb-3">Hubungi <span class="text-primary">Kami</span></h1>
                <p class="lead text-muted">Butuh bantuan? Kami siap membantu Anda</p>
            </div>

            <div class="row">
                <!-- Contact Information -->
                <div class="col-lg-5 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Informasi Kontak</h3>
                            
                            <div class="mb-4">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mr-3" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-map-marker-alt fa-lg text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Alamat</h5>
                                        <p class="text-muted mb-0">
                                            Jl. Fotografi No. 123<br>
                                            Jakarta Selatan, 12540<br>
                                            Indonesia
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start mb-3">
                                    <div class="rounded-circle bg-success d-flex align-items-center justify-content-center mr-3" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-phone fa-lg text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Telepon</h5>
                                        <p class="text-muted mb-0">
                                            (021) 1234-5678<br>
                                            0812-3456-7890 (WhatsApp)
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start">
                                    <div class="rounded-circle bg-info d-flex align-items-center justify-content-center mr-3" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-envelope fa-lg text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Email</h5>
                                        <p class="text-muted mb-0">
                                            info@fotorental.com<br>
                                            support@fotorental.com
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <h5 class="mb-3">Jam Operasional</h5>
                            <ul class="list-unstyled text-muted">
                                <li class="mb-2">
                                    <i class="far fa-clock mr-2"></i>
                                    Senin - Jumat: 08:00 - 22:00
                                </li>
                                <li class="mb-2">
                                    <i class="far fa-clock mr-2"></i>
                                    Sabtu - Minggu: 09:00 - 20:00
                                </li>
                                <li>
                                    <i class="fas fa-info-circle mr-2"></i>
                                    24/7 untuk pertanyaan via WhatsApp
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="col-lg-7 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Kirim Pesan</h3>
                            
                            @if(session('success'))
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                                </div>
                            @endif
                            
                            <form action="{{ url('/contact') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nama Lengkap *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="subject">Subjek *</label>
                                    <select class="form-control @error('subject') is-invalid @enderror" 
                                            id="subject" name="subject" required>
                                        <option value="">Pilih Subjek</option>
                                        <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>Pertanyaan Umum</option>
                                        <option value="rental" {{ old('subject') == 'rental' ? 'selected' : '' }}>Pertanyaan Penyewaan</option>
                                        <option value="technical" {{ old('subject') == 'technical' ? 'selected' : '' }}>Bantuan Teknis</option>
                                        <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Kerjasama</option>
                                        <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="message">Pesan *</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-paper-plane mr-2"></i> Kirim Pesan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Map Section -->
            <div class="card shadow-sm mt-4">
                <div class="card-body p-0">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613506864!3d-6.194741395493371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e67356080477!2sJakarta%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1580041225855!5m2!1sid!2sid" 
                                width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection