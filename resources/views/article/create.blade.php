@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Tambah Artikel Baru</h1>
            <p class="text-muted">Buat dan publikasikan artikel menarik untuk Jelajah Tangerang.</p>
        </div>

        <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Kolom Kiri: Konten Utama -->
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Konten Artikel</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Judul Artikel</label>
                                <input type="text" name="title"
                                    class="form-control form-control-lg @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}" placeholder="Masukkan judul artikel...">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konten</label>
                                <textarea name="content" rows="15" class="form-control @error('content') is-invalid @enderror"
                                    placeholder="Tuliskan isi artikel disini...">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Meta Data & Publish -->
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Pengaturan Publikasi</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Thumbnail</label>
                                <input type="file" name="thumbnail"
                                    class="form-control @error('thumbnail') is-invalid @enderror">
                                <small class="text-muted d-block mt-1">Format: jpg, png, jpeg. Max: 2MB</small>
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jadwal Publish</label>
                                <input type="datetime-local" name="published_at"
                                    class="form-control @error('published_at') is-invalid @enderror"
                                    value="{{ old('published_at') }}">
                                <small class="text-muted d-block mt-1">Biarkan kosong untuk menyimpan sebagai
                                    <b>Draft</b>.</small>
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                                <a href="{{ route('artikel.index') }}" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
