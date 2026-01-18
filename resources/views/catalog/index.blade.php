@extends('layouts.app')

@section('title', 'Katalog Peralatan - FotoRental')

@section('content')
<style>
    /* Custom CSS untuk mempercantik tampilan */
    .equipment-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        border-radius: 12px;
        overflow: hidden;
    }
    .equipment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .equipment-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 220px;
    }
    .equipment-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .equipment-card:hover .equipment-image {
        transform: scale(1.05);
    }
    .card-badges {
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        display: flex;
        justify-content: space-between;
        z-index: 2;
    }
    .filter-section {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #f0f0f0;
    }
    .price-tag {
        font-weight: 700;
        color: #2c3e50;
        font-size: 1.1rem;
    }
</style>

    <section class="bg-primary text-white py-5 position-relative overflow-hidden">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-2">Katalog Peralatan</h1>
                    <p class="lead mb-0 opacity-75">Temukan kamera, lensa, dan lighting terbaik untuk karya Anda.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('dashboard') }}" class="btn btn-light shadow-sm fw-bold">
                        <i class="fas fa-history me-2"></i>Riwayat Sewa
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 bg-light">
        <div class="container">
            <div class="filter-section p-4">
                <form method="GET" action="{{ route('catalog.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="search" class="form-label text-muted small fw-bold text-uppercase">Pencarian</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="search" name="search" 
                                   placeholder="Cari nama kamera, lensa..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="category" class="form-label text-muted small fw-bold text-uppercase">Kategori</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            Filter Hasil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                @forelse($equipment as $item)
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="card h-100 equipment-card">
                        <div class="equipment-image-wrapper">
                            <div class="card-badges">
                                <span class="badge bg-light text-dark shadow-sm">
                                    <i class="fas fa-tag me-1"></i>{{ $item->category->name }}
                                </span>
                                <span class="badge {{ $item->stock > 0 ? 'bg-success' : 'bg-danger' }} shadow-sm">
                                    {{ $item->stock > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>
          <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/default.jpg') }}"
     class="equipment-image"
     alt="{{ $item->name }}">

                        </div>

                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold mb-2">{{ $item->name }}</h5>
                            <p class="card-text text-muted small grow">
                                {{ Str::limit($item->description, 100) }}
                            </p>
                            
                            <hr class="my-3 opacity-10">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted"><i class="fas fa-box me-1"></i>Stok: {{ $item->stock }}</small>
                                <span class="price-tag text-primary">
                                    Rp {{ number_format($item->price_per_day, 0, ',', '.') }}<span class="text-muted small fw-normal">/hari</span>
                                </span>
                            </div>
                            
                            @if($item->stock > 0)
                                @auth
                                    <button class="btn btn-primary rent-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rentalModal"
                                            data-equipment-id="{{ $item->id }}"
                                            data-equipment-name="{{ $item->name }}"
                                            data-equipment-price="{{ $item->price_per_day }}"
                                            data-equipment-image="{{ $item->image ? asset('storage/'.$item->image) : asset('images/default.jpg') }}"
                                            <i class="fas fa-shopping-bag me-1"></i> Sewa
                                    </button>

                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
                                        Login untuk Sewa
                                    </a>
                                @endauth
                            @else
                                <button class="btn btn-secondary w-100" disabled>
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="py-5">
                        <i class="fas fa-camera fa-4x text-muted mb-3 opacity-25"></i>
                        <h4 class="text-muted">Tidak ada peralatan yang ditemukan</h4>
                        <p class="text-muted mb-4">Coba ubah kata kunci atau kategori pencarian Anda</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary px-4">Reset Filter</a>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $equipment->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>

    @auth
    <div class="modal fade" id="rentalModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-shopping-bag me-2"></i>Form Penyewaan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('rentals.store') }}" method="POST">
                    @csrf
                     <input type="hidden" name="equipment_id" id="modal_equipment_id" value="">
                    
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-5 text-center border-end">
                                <img id="modal_equipment_image" src="" alt="" class="img-fluid rounded shadow-sm mb-3" style="max-height: 200px; width: 100%; object-fit: cover;">
                                <h5 id="modal_equipment_name" class="fw-bold mb-1"></h5>
                                <p class="text-primary fw-bold fs-5" id="modal_equipment_price"></p>
                            </div>

                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label small text-muted text-uppercase fw-bold">Tanggal Sewa</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="rental_date" name="rental_date" min="{{ date('Y-m-d') }}" required>
                                        <span class="input-group-text">s/d</span>
                                        <input type="date" class="form-control" id="return_date" name="return_date" required>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="quantity" class="form-label small text-muted text-uppercase fw-bold">Jumlah Unit</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                                </div>
                                
                                <div class="bg-light p-3 rounded border">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Durasi:</span>
                                        <span id="rental_days" class="fw-bold">0 hari</span>
                                    </div>
                                    <div class="d-flex justify-content-between fs-5 text-primary">
                                        <span class="fw-bold">Total Biaya:</span>
                                        <span id="total_price" class="fw-bold">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-link text-secondary text-decoration-none" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Konfirmasi Sewa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endauth
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rentButtons = document.querySelectorAll('.rent-btn');
        
        rentButtons.forEach(button => {
            button.addEventListener('click', function() {
                const equipmentId = this.getAttribute('data-equipment-id');
                const equipmentName = this.getAttribute('data-equipment-name');
                const equipmentPrice = this.getAttribute('data-equipment-price');
                const equipmentImage = this.getAttribute('data-equipment-image');
                
                console.log('Equipment Data:', {
                    id: equipmentId,
                    name: equipmentName,
                    price: equipmentPrice,
                    image: equipmentImage
                });
                
                // Pastikan nilai tidak kosong
                if (!equipmentId) {
                    console.error('Equipment ID is empty!');
                    alert('Terjadi kesalahan: ID peralatan tidak ditemukan');
                    return;
                }
                
                document.getElementById('modal_equipment_id').value = equipmentId;
                document.getElementById('modal_equipment_name').textContent = equipmentName;
                document.getElementById('modal_equipment_price').textContent = 
                    'Rp ' + parseInt(equipmentPrice).toLocaleString('id-ID') + '/hari';
                document.getElementById('modal_equipment_image').src = equipmentImage;
                
                // Reset form dengan tanggal minimal hari ini
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('rental_date').value = today;
                document.getElementById('return_date').value = '';
                document.getElementById('rental_date').min = today;
                document.getElementById('return_date').min = today;
                document.getElementById('quantity').value = 1;
                
                // Simpan harga asli untuk perhitungan
                document.getElementById('modal_equipment_price').setAttribute('data-price', equipmentPrice);
                
                updateRentalCalculation();
            });
        });
        
        const rentalDateInput = document.getElementById('rental_date');
        const returnDateInput = document.getElementById('return_date');
        const quantityInput = document.getElementById('quantity');
        
        if (rentalDateInput) {
            rentalDateInput.addEventListener('change', function() {
                // Set tanggal minimal untuk return date
                if (this.value) {
                    const minReturnDate = new Date(this.value);
                    minReturnDate.setDate(minReturnDate.getDate() + 1);
                    returnDateInput.min = minReturnDate.toISOString().split('T')[0];
                    
                    if (returnDateInput.value && new Date(returnDateInput.value) < minReturnDate) {
                        returnDateInput.value = '';
                    }
                }
                updateRentalCalculation();
            });
            
            returnDateInput.addEventListener('change', updateRentalCalculation);
            quantityInput.addEventListener('input', updateRentalCalculation);
        }
        
        function updateRentalCalculation() {
            const rentalDate = new Date(rentalDateInput.value);
            const returnDate = new Date(returnDateInput.value);
            const quantity = parseInt(quantityInput.value) || 1;
            
            // Dapatkan harga dari data attribute
            const priceElement = document.getElementById('modal_equipment_price');
            const equipmentPrice = parseFloat(priceElement.getAttribute('data-price')) || 0;
            
            console.log('Calculation Data:', {
                rentalDate: rentalDateInput.value,
                returnDate: returnDateInput.value,
                quantity: quantity,
                price: equipmentPrice
            });
            
            if (rentalDate && returnDate && returnDate > rentalDate) {
                // Hitung selisih hari
                const timeDiff = returnDate.getTime() - rentalDate.getTime();
                let daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                
                // Pastikan minimal 1 hari
                daysDiff = Math.max(1, daysDiff);
                
                if (daysDiff > 0) {
                    document.getElementById('rental_days').textContent = daysDiff + ' hari';
                    const totalPrice = daysDiff * equipmentPrice * quantity;
                    document.getElementById('total_price').textContent = 
                        'Rp ' + totalPrice.toLocaleString('id-ID');
                } else {
                    document.getElementById('rental_days').textContent = '0 hari';
                    document.getElementById('total_price').textContent = 'Rp 0';
                }
            } else {
                document.getElementById('rental_days').textContent = '0 hari';
                document.getElementById('total_price').textContent = 'Rp 0';
            }
        }
        
        // Validasi form sebelum submit
        const rentalForm = document.querySelector('#rentalModal form');
        if (rentalForm) {
            rentalForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const equipmentId = document.getElementById('modal_equipment_id').value;
                const rentalDate = document.getElementById('rental_date').value;
                const returnDate = document.getElementById('return_date').value;
                const quantity = document.getElementById('quantity').value;
                
                console.log('Form Submit Data:', {
                    equipmentId: equipmentId,
                    rentalDate: rentalDate,
                    returnDate: returnDate,
                    quantity: quantity
                });
                
                // Validasi dasar
                if (!equipmentId || !rentalDate || !returnDate || !quantity || quantity < 1) {
                    alert('Harap lengkapi semua field dengan benar!');
                    return false;
                }
                
                if (new Date(returnDate) <= new Date(rentalDate)) {
                    alert('Tanggal kembali harus setelah tanggal sewa!');
                    return false;
                }

                  // Debug: Cek apakah form bisa disubmit
                    console.log('All validations passed, submitting form...');
                    
                    // Tampilkan loading
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memproses...';
                    submitBtn.disabled = true;
                
                // Submit form
                    setTimeout(() => {
                    console.log('Actually submitting form...');
                    this.submit();
                }, 100);
            });
        }
    });
</script>
@endpush