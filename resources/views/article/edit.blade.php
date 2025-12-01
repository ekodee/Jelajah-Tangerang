@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Edit Artikel</h1>
            <p class="text-muted">Perbarui konten artikel Jelajah Tangerang.</p>
        </div>

        <form action="{{ route('artikel.update', $article->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                                    value="{{ old('title', $article->title) }}" placeholder="Masukkan judul artikel...">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konten</label>
                                <textarea name="content" rows="15" class="form-control @error('content') is-invalid @enderror"
                                    placeholder="Tuliskan isi artikel disini...">{{ old('content', $article->content) }}</textarea>
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
                                <label class="form-label">Thumbnail Saat Ini</label>
                                @if ($article->thumbnail)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                            class="img-fluid rounded border" alt="Current Image"
                                            style="max-height: 200px; width: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    <div class="alert alert-secondary py-2">Belum ada thumbnail.</div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ganti Thumbnail</label>
                                <input type="file" name="thumbnail"
                                    class="form-control @error('thumbnail') is-invalid @enderror">
                                <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengubah
                                    gambar.</small>
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jadwal Publish</label>
                                <input type="datetime-local" name="published_at"
                                    class="form-control @error('published_at') is-invalid @enderror"
                                    value="{{ old('published_at', $article->published_at) }}">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Update Artikel</button>
                                <a href="{{ route('artikel.index') }}" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
