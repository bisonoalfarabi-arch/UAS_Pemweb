@extends('layouts.app')

@section('title', 'Detail Penyewaan - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Detail Penyewaan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.rentals.index') }}">Penyewaan</a></li>
                    <li class="breadcrumb-item active">#{{ str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.rentals.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column - Rental Details -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Penyewaan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Kode Penyewaan</th>
                                    <td>:</td>
                                    <td><strong>#{{ str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pesan</th>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($rental->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Sewa</th>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kembali</th>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($rental->return_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Durasi</th>
                                    <td>:</td>
                                    <td><span class="badge badge-info">{{ $rental->total_days }} hari</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Status</th>
                                    <td>:</td>
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
                                </tr>
                                <tr>
                                    <th>Total Harga</th>
                                    <td>:</td>
                                    <td class="h5 text-success font-weight-bold">
                                        Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($rental->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Update Terakhir</th>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($rental->updated_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipment Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Peralatan</h6>
                    <a href="{{ route('admin.equipment.edit', $rental->equipment) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit Peralatan
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            @if($rental->equipment->image)
                                <img src="{{ asset('storage/' . $rental->equipment->image) }}" 
                                     alt="{{ $rental->equipment->name }}" 
                                     class="img-fluid rounded mb-3" style="max-height: 150px;">
                            @else
                                <div class="bg-light rounded p-4 mb-3">
                                    <i class="fas fa-camera fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h5 class="font-weight-bold">{{ $rental->equipment->name }}</h5>
                            <p class="text-muted">{{ $rental->equipment->description }}</p>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="text-muted">Harga per Hari</div>
                                    <div class="h5">Rp {{ number_format($rental->equipment->price_per_day, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-muted">Stok Tersedia</div>
                                    <div class="h5">
                                        <span class="badge badge-{{ $rental->equipment->stock > 0 ? 'success' : 'danger' }}">
                                            {{ $rental->equipment->stock }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-muted">Kategori</div>
                                    <div class="h6">{{ $rental->equipment->category->name ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - User Info & Actions -->
        <div class="col-md-4">
            <!-- User Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Penyewa</h6>
                    <a href="{{ route('admin.users.show', $rental->user) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-user"></i> Profil
                    </a>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <span class="h4 text-white">{{ substr($rental->user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <h5 class="font-weight-bold">{{ $rental->user->name }}</h5>
                    <p class="text-muted">{{ $rental->user->email }}</p>
                    <p class="text-muted">{{ $rental->user->phone ?? 'No Telepon tidak tersedia' }}</p>
                    
                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h4 mb-0">{{ $userStats['total_rentals'] }}</div>
                            <div class="text-muted small">Total Sewa</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 mb-0 text-success">{{ $userStats['completed_rentals'] }}</div>
                            <div class="text-muted small">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($rental->status == 'pending')
                            <form action="{{ route('admin.rentals.approve', $rental) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-block" 
                                        onclick="return confirm('Setujui penyewaan ini?')">
                                    <i class="fas fa-check"></i> Setujui Penyewaan
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.rentals.reject', $rental) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger btn-block" 
                                        onclick="return confirm('Tolak penyewaan ini?')">
                                    <i class="fas fa-times"></i> Tolak Penyewaan
                                </button>
                            </form>
                        @endif
                        
                        @if($rental->status == 'active')
                            <form action="{{ route('admin.rentals.complete', $rental) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-block" 
                                        onclick="return confirm('Selesaikan penyewaan ini?')">
                                    <i class="fas fa-flag-checkered"></i> Selesaikan Penyewaan
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('admin.rentals.destroy', $rental) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-block" 
                                    onclick="return confirm('Hapus penyewaan ini?')">
                                <i class="fas fa-trash"></i> Hapus Penyewaan
                            </button>
                        </form>
                        
                        <a href="#" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#sendMessageModal">
                            <i class="fas fa-envelope"></i> Kirim Pesan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Send Message Modal -->
<div class="modal fade" id="sendMessageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Kirim Pesan ke {{ $rental->user->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="subject">Subjek</label>
                        <input type="text" class="form-control" id="subject" 
                               value="Update Penyewaan #{{ str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}">
                    </div>
                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea class="form-control" id="message" rows="5" 
                                  placeholder="Tulis pesan untuk penyewa..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection