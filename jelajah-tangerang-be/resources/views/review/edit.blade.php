@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Edit Review</h1>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Form Edit Ulasan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('review.update', $review->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="alert alert-info py-2 mb-3">
                                <small>Edit target review jika diperlukan (Pilih salah satu).</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Destinasi</label>
                                <select name="destination_id"
                                    class="form-select @error('destination_id') is-invalid @enderror">
                                    <option value="">-- Tidak Dipilih --</option>
                                    @foreach ($destinations as $dest)
                                        <option value="{{ $dest->id }}"
                                            {{ old('destination_id', $review->destination_id) == $dest->id ? 'selected' : '' }}>
                                            {{ $dest->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Artikel</label>
                                <select name="article_id" class="form-select @error('article_id') is-invalid @enderror">
                                    <option value="">-- Tidak Dipilih --</option>
                                    @foreach ($articles as $art)
                                        <option value="{{ $art->id }}"
                                            {{ old('article_id', $review->article_id) == $art->id ? 'selected' : '' }}>
                                            {{ $art->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <select name="rating" class="form-select @error('rating') is-invalid @enderror">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}"
                                            {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>
                                            {{ $i }} Bintang
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Komentar</label>
                                <textarea name="comment" rows="4" class="form-control @error('comment') is-invalid @enderror">{{ old('comment', $review->comment) }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('review.index') }}" class="btn btn-outline-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Update Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
