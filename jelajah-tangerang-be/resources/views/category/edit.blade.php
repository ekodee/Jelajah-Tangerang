@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Edit Kategori</h1>
            <p class="text-muted">Perbarui nama kategori yang sudah ada.</p>
        </div>

        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Data Kategori</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="name" class="form-label fw-bold">Nama Kategori</label>
                                <input type="text" name="name" id="name"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    value="{{ old('name', $kategori->name) }}" placeholder="Contoh: Wisata Alam">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Info Tambahan PENTING saat Edit --}}
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <i class="align-middle me-2" data-feather="alert-triangle"></i>
                                <div>
                                    <strong>Perhatian:</strong> Mengubah nama kategori akan memperbarui <em>Slug</em> (URL)
                                    secara otomatis. Pastikan tidak ada link eksternal yang rusak.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Aksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted small">Dibuat pada</label>
                                <input type="text" class="form-control form-control-sm"
                                    value="{{ $kategori->created_at->format('d M Y, H:i') }}" readonly disabled>
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="align-middle me-1" data-feather="save"></i> Update Kategori
                                </button>
                                <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
