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

                            <div class="mb-3">
                                <label class="form-label">Pilih Destinasi</label>
                                <select name="destination_id"
                                    class="form-select @error('destination_id') is-invalid @enderror">
                                    <option value="" disabled>-- Cari Destinasi --</option>
                                    @foreach ($destinations as $destination)
                                        <option value="{{ $destination->id }}"
                                            {{ old('destination_id', $review->destination_id) == $destination->id ? 'selected' : '' }}>
                                            {{ $destination->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('destination_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Berikan Rating</label>
                                <select name="rating" class="form-select @error('rating') is-invalid @enderror">
                                    <option value="" disabled>-- Pilih Bintang --</option>
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}"
                                            {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>
                                            {{ $i }} Bintang
                                        </option>
                                    @endfor
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Komentar Pengunjung</label>
                                <textarea name="comment" rows="5" class="form-control @error('comment') is-invalid @enderror">{{ old('comment', $review->comment) }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
