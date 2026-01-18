@extends('layouts.app')

@section('title', 'Detail - ' . $equipment->name)

@section('content')
<div class="container py-4">
    <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="card shadow-sm">
        <div class="row g-0">
            <div class="col-md-5">
                <img
                    src="{{ $equipment->image ? asset('storage/'.$equipment->image) : asset('images/default.jpg') }}"
                    class="img-fluid rounded-start"
                    style="width:100%; height:350px; object-fit:cover;"
                    alt="{{ $equipment->name }}"
                >
            </div>
            <div class="col-md-7">
                <div class="card-body">
                    <h3 class="card-title">{{ $equipment->name }}</h3>
                    <p class="text-muted mb-1">
                        Kategori: {{ $equipment->category->name ?? '-' }}
                    </p>

                    <h5 class="text-primary mt-3">
                        Rp {{ number_format($equipment->price_per_day ?? 0, 0, ',', '.') }}/hari
                    </h5>

                    <p class="mt-3">{{ $equipment->description }}</p>

                    <span class="badge bg-{{ ($equipment->stock ?? 0) > 0 ? 'success' : 'danger' }}">
                        {{ ($equipment->stock ?? 0) > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
