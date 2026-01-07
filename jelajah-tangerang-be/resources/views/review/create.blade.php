@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Tambah Review Manual</h1>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Form Ulasan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('review.store') }}" method="POST">
                            @csrf

                            {{-- PILIHAN TARGET (Salah satu harus diisi) --}}
                            <div class="alert alert-info py-2 mb-3">
                                <small><i data-feather="info" width="14"></i> Isi salah satu saja: Destinasi <b>ATAU</b> Artikel.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih Destinasi (Opsional)</label>
                                <select name="destination_id" class="form-select @error('destination_id') is-invalid @enderror">
                                    <option value="">-- Kosongkan jika mereview Artikel --</option>
                                    @foreach ($destinations as $dest)
                                        <option value="{{ $dest->id }}" {{ old('destination_id') == $dest->id ? 'selected' : '' }}>
                                            {{ $dest->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('destination_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih Artikel (Opsional)</label>
                                <select name="article_id" class="form-select @error('article_id') is-invalid @enderror">
                                    <option value="">-- Kosongkan jika mereview Destinasi --</option>
                                    @foreach ($articles as $art)
                                        <option value="{{ $art->id }}" {{ old('article_id') == $art->id ? 'selected' : '' }}>
                                            {{ $art->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('article_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <select name="rating" class="form-select @error('rating') is-invalid @enderror">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                            {{ $i }} Bintang
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Komentar</label>
                                <textarea name="comment" rows="4" class="form-control @error('comment') is-invalid @enderror" placeholder="Isi komentar...">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('review.index') }}" class="btn btn-outline-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection