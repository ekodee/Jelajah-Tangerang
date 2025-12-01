@extends('layouts.app')

@section('content')
    <h2>Tambah Review Baru</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('review.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Destinasi</label>
                    <select name="destination_id" class="form-control @error('destination_id') is-invalid @enderror">
                        <option value="">-- Pilih Destinasi --</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}"
                                {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                                {{ $destination->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('destination_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <select name="rating" class="form-control @error('rating') is-invalid @enderror">
                        <option value="">-- Pilih Rating --</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Komentar</label>
                    <textarea name="comment" rows="5" class="form-control @error('comment') is-invalid @enderror">{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Review</button>
                    <a href="{{ route('review.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
