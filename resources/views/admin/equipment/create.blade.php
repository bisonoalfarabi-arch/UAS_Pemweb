@extends('layouts.app')

@section('title', 'Tambah Peralatan - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tambah Peralatan Baru</h1>
        <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.equipment.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name">Nama Peralatan *</label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
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
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Deskripsi *</label>
                    <textarea
                        class="form-control @error('description') is-invalid @enderror"
                        id="description"
                        name="description"
                        rows="3"
                        required
                    >{{ old('description') }}</textarea>
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
                                value="{{ old('price_per_day') }}"
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
                                value="{{ old('stock') }}"
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
                    <label for="image">Gambar Peralatan</label>
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

                    {{-- Preview --}}
                    <div class="mt-3" id="previewWrap" style="display:none;">
                        <p class="mb-2 text-muted">Preview:</p>
                        <img id="previewImg" src="#" alt="Preview" style="max-height: 200px;" class="img-thumbnail">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-secondary" id="btnReset">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JS preview sederhana --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image');
    const wrap = document.getElementById('previewWrap');
    const img  = document.getElementById('previewImg');
    const btnReset = document.getElementById('btnReset');

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

    btnReset?.addEventListener('click', function () {
        wrap.style.display = 'none';
        img.src = '#';
    });
});
</script>
@endsection
