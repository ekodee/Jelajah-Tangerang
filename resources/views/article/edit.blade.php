@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <h2>Edit Artikel</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('artikel.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Judul Artikel</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $article->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konten</label>
                            <textarea name="content" rows="10" class="form-control @error('content') is-invalid @enderror">{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Thumbnail Saat Ini</label>
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" class="img-fluid rounded"
                                    alt="Current Image">
                            </div>
                            <label class="form-label">Ganti Thumbnail (Opsional)</label>
                            <input type="file" name="thumbnail"
                                class="form-control @error('thumbnail') is-invalid @enderror">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Publish</label>
                            <input type="datetime-local" name="published_at" class="form-control"
                                value="{{ old('published_at', $article->published_at) }}">
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Update Artikel</button>
                            <a href="{{ route('artikel.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
