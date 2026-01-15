@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Tambah Kategori Baru</h1>
            <p class="text-muted">Buat kategori untuk mengelompokkan Destinasi atau Artikel.</p>
        </div>

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
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
                                    value="{{ old('name') }}" placeholder="Contoh: Wisata Alam, Kuliner, Sejarah"
                                    autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Info Tambahan agar tidak terlalu kosong --}}
                            <div class="alert alert-light border-start border-info border-3" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="align-middle me-2 text-info" data-feather="info"></i>
                                    <div>
                                        <small class="text-muted"><strong>Catatan:</strong> <em>Slug</em> (URL ramah SEO) akan dibuat
                                            secara otomatis berdasarkan nama kategori yang Anda masukkan.</small>
                                    </div>
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
                            <p class="text-sm text-muted mb-3">
                                Pastikan nama kategori singkat, padat, dan jelas agar mudah dicari oleh pengunjung.
                            </p>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="align-middle me-1" data-feather="save"></i> Simpan Kategori
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