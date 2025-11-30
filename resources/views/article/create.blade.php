@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <h2>Tambah Artikel Baru</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Judul Artikel</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" placeholder="Masukkan judul menarik...">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konten</label>
                            <textarea name="content" rows="10" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan (Meta Data) -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Thumbnail</label>
                            <input type="file" name="thumbnail"
                                class="form-control @error('thumbnail') is-invalid @enderror">
                            <small class="text-muted">Format: jpg, png, jpeg. Max: 2MB</small>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Publish</label>
                            <input type="datetime-local" name="published_at"
                                class="form-control @error('published_at') is-invalid @enderror"
                                value="{{ old('published_at') }}">
                            <small class="text-muted">Kosongkan jika ingin menyimpannya sebagai <b>Draft</b>.</small>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                            <a href="{{ route('artikel.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
