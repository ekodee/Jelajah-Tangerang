@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor .note-toolbar {
            background: #f8f9fa;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Edit Artikel</h1>
            <p class="text-muted">Perbarui konten artikel Jelajah Tangerang.</p>
        </div>

        <form action="{{ route('artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
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
                                    value="{{ old('title', $artikel->title) }}" placeholder="Masukkan judul artikel...">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="" disabled>-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $artikel->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konten</label>
                                <textarea id="summernote" name="content" class="form-control @error('content') is-invalid @enderror">{{ old('content', $artikel->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Pengaturan Publikasi</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Thumbnail Saat Ini</label>
                                @if ($artikel->thumbnail)
                                    <div class="mb-2">
                                        {{-- LOGIC BARU: Cek apakah URL http atau path lokal --}}
                                        @php
                                            $imageSrc = Str::startsWith($artikel->thumbnail, 'http')
                                                ? $artikel->thumbnail
                                                : asset('storage/' . $artikel->thumbnail);
                                        @endphp

                                        <img src="{{ $imageSrc }}" class="img-fluid rounded border" alt="Current Image"
                                            style="max-height: 200px; width: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    ...
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
                                    value="{{ old('published_at', $artikel->published_at) }}">
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

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Tuliskan isi artikel disini...',
                tabsize: 2,
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        for (let i = 0; i < files.length; i++) {
                            uploadImage(files[i]);
                        }
                    }
                }
            });

            // Fungsi upload gambar yang sama dengan Create
            function uploadImage(file) {
                let data = new FormData();
                data.append("file", file);
                data.append("_token", "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('artikel.upload_image') }}", // Route tetap sama
                    method: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#summernote').summernote('insertImage', response.url);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Gagal mengupload gambar.');
                    }
                });
            }
        });
    </script>
@endpush
