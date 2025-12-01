@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor .note-toolbar {
            background: #f8f9fa;
            /* Sesuaikan dengan tema AdminKit */
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Tambah Artikel Baru</h1>
            <p class="text-muted">Buat dan publikasikan artikel menarik untuk Jelajah Tangerang.</p>
        </div>

        <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                                    value="{{ old('title') }}" placeholder="Masukkan judul artikel...">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konten</label>
                                <textarea id="summernote" name="content" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
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
                    // Callback khusus saat gambar di-upload/drag-n-drop
                    onImageUpload: function(files) {
                        for (let i = 0; i < files.length; i++) {
                            uploadImage(files[i]);
                        }
                    }
                }
            });

            // Fungsi AJAX untuk upload gambar ke Laravel
            function uploadImage(file) {
                let data = new FormData();
                data.append("file", file);
                data.append("_token", "{{ csrf_token() }}"); // Token CSRF Laravel

                $.ajax({
                    url: "{{ route('artikel.upload_image') }}",
                    method: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Jika sukses, masukkan URL gambar ke editor
                        $('#summernote').summernote('insertImage', response.url);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Gagal mengupload gambar. Cek konsol browser.');
                    }
                });
            }
        });
    </script>
@endpush
