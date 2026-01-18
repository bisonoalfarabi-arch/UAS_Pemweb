@extends('layouts.app')

@section('title', 'Edit Peralatan - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Peralatan</h1>
        <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            {{-- Flash message --}}
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
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.equipment.update', $equipment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="name">Nama Peralatan *</label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $equipment->name) }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="category_id">Kategori *</label>
                            <select
                                class="form-control @error('category_id') is-invalid @enderror"
                                id="category_id"
                                name="category_id"
                                required
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $equipment->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Deskripsi *</label>
                            <textarea
                                class="form-control @error('description') is-invalid @enderror"
                                id="description"
                                name="description"
                                rows="4"
                                required
                            >{{ old('description', $equipment->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="price_per_day">Harga per Hari (Rp) *</label>
                                    <input
                                        type="number"
                                        class="form-control @error('price_per_day') is-invalid @enderror"
                                        id="price_per_day"
                                        name="price_per_day"
                                        value="{{ old('price_per_day', $equipment->price_per_day) }}"
                                        min="0"
                                        step="0.01"
                                        required
                                    >
                                    @error('price_per_day')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Contoh: 150000 atau 150000.00</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="stock">Stok *</label>
                                    <input
                                        type="number"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        id="stock"
                                        name="stock"
                                        value="{{ old('stock', $equipment->stock) }}"
                                        min="0"
                                        required
                                    >
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="image">Ganti Gambar (opsional)</label>
                            <input
                                type="file"
                                class="form-control @error('image') is-invalid @enderror"
                                id="image"
                                name="image"
                                accept="image/*"
                            >
                            <small class="form-text text-muted">
                                Format: JPG, PNG, GIF. Maksimal: 2MB
                            </small>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            {{-- Preview file baru --}}
                            <div class="mt-3" id="previewWrap" style="display:none;">
                                <p class="mb-2 text-muted">Preview gambar baru:</p>
                                <img id="previewImg" src="#" alt="Preview" style="max-height: 220px;" class="img-thumbnail">
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="mb-3">Gambar Saat Ini</h6>

                            @if($equipment->image)
                                <img
                                    src="{{ asset('storage/' . $equipment->image) }}"
                                    alt="{{ $equipment->name }}"
                                    class="img-fluid img-thumbnail"
                                >
                                <small class="d-block mt-2 text-muted">
                                    File: {{ $equipment->image }}
                                </small>
                            @else
                                <div class="text-muted">Belum ada gambar.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image');
    const wrap = document.getElementById('previewWrap');
    const img  = document.getElementById('previewImg');

    input?.addEventListener('change', function (e) {
        const file = e.target.files && e.target.files[0];
        if (!file) {
            wrap.style.display = 'none';
            img.src = '#';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (ev) {
            img.src = ev.target.result;
            wrap.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection
