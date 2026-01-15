@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Tambah Review Manual</h1>
            <p class="text-muted">Tambahkan ulasan atau testimoni pengguna secara manual.</p>
        </div>

        <form action="{{ route('review.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Target Ulasan</h5>
                        </div>
                        <div class="card-body">
                            {{-- ALERT INFO --}}
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <div class="alert-icon">
                                    <i class="align-middle" data-feather="info"></i>
                                </div>
                                <div class="alert-message">
                                    <strong>Perhatian:</strong> Silakan pilih salah satu target ulasan, entah itu
                                    <strong>Destinasi</strong> atau <strong>Artikel</strong>. Jangan diisi keduanya.
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Pilih Destinasi</label>
                                    <select name="destination_id"
                                        class="form-select @error('destination_id') is-invalid @enderror">
                                        <option value="">-- Tidak Memilih Destinasi --</option>
                                        @foreach ($destinations as $dest)
                                            <option value="{{ $dest->id }}"
                                                {{ old('destination_id') == $dest->id ? 'selected' : '' }}>
                                                {{ $dest->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('destination_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Pilih Artikel</label>
                                    <select name="article_id" class="form-select @error('article_id') is-invalid @enderror">
                                        <option value="">-- Tidak Memilih Artikel --</option>
                                        @foreach ($articles as $art)
                                            <option value="{{ $art->id }}"
                                                {{ old('article_id') == $art->id ? 'selected' : '' }}>
                                                {{ $art->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('article_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Isi Komentar</label>
                                <textarea name="comment" rows="6" class="form-control @error('comment') is-invalid @enderror"
                                    placeholder="Tuliskan pengalaman atau pendapat tentang destinasi/artikel ini...">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Penilaian</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Berikan Rating</label>
                                <select name="rating" class="form-select form-select-lg @error('rating') is-invalid @enderror">
                                    <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (Sempurna)
                                    </option>
                                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (Bagus)
                                    </option>
                                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ (Cukup)
                                    </option>
                                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ (Kurang)
                                    </option>
                                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ (Buruk)
                                    </option>
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="align-middle me-1" data-feather="save"></i> Simpan Review
                                </button>
                                <a href="{{ route('review.index') }}" class="btn btn-outline-secondary">
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