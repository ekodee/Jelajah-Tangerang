@extends('layouts.app')

@section('content')
    <h2>Edit Destinasi</h2>

    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('destinasi.update', $destinasi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $destinasi->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Destinasi</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $destinasi->name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control">{{ old('description', $destinasi->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="address" class="form-control"
                        value="{{ old('address', $destinasi->address) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jam Buka</label>
                    <input type="text" name="open_hours" class="form-control"
                        value="{{ old('open_hours', $destinasi->open_hours) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Latitude</label>
                    <input type="text" name="latitude" class="form-control"
                        value="{{ old('latitude', $destinasi->latitude) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Longitude</label>
                    <input type="text" name="longitude" class="form-control"
                        value="{{ old('longitude', $destinasi->longitude) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="photo" class="form-control">
                    @if ($destinasi->photo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $destinasi->photo) }}" alt="" width="120">
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('destinasi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
