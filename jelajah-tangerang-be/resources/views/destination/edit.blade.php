@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Edit Destinasi Wisata</h1>
        </div>

        <form action="{{ route('destinasi.update', $destinasi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informasi Umum</h5>
                        </div>
                        <div class="card-body">
                            {{-- BAGIAN INPUT TEXT TETAP SAMA (Name, Category, Description) --}}
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Nama Destinasi</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $destinasi->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select name="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror">
                                        <option value="" disabled>Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $destinasi->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Singkat</label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $destinasi->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Lokasi & Peta</h5>
                        </div>
                        <div class="card-body">
                            {{-- BAGIAN LOKASI TETAP SAMA --}}
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address', $destinasi->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" name="latitude"
                                        class="form-control @error('latitude') is-invalid @enderror"
                                        value="{{ old('latitude', $destinasi->latitude) }}">
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" name="longitude"
                                        class="form-control @error('longitude') is-invalid @enderror"
                                        value="{{ old('longitude', $destinasi->longitude) }}">
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Detail Tambahan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Foto Saat Ini</label>
                                @if ($destinasi->photo)
                                    <div class="mb-2">
                                        {{-- LOGIC PERBAIKAN DI SINI --}}
                                        @php
                                            $imageSrc = Str::startsWith($destinasi->photo, 'http')
                                                ? $destinasi->photo
                                                : asset('storage/' . $destinasi->photo);
                                        @endphp

                                        <img src="{{ $imageSrc }}" class="img-fluid rounded border"
                                            alt="Foto Destinasi" style="max-height: 200px; width: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    <div class="alert alert-secondary py-2">Belum ada foto.</div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ganti Foto</label>
                                <input type="file" name="photo"
                                    class="form-control @error('photo') is-invalid @enderror">
                                <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengganti
                                    foto.</small>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Jam Operasional</label>
                                <input type="text" name="open_hours"
                                    class="form-control @error('open_hours') is-invalid @enderror"
                                    value="{{ old('open_hours', $destinasi->open_hours) }}">
                                @error('open_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Update Destinasi</button>
                                <a href="{{ route('destinasi.index') }}" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
