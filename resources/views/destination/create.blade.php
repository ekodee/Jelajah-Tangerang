<x-app-layout>
    <x-slot name="header">
        <h2>Tambah Destinasi</h2>
    </x-slot>

    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('destinasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Destinasi</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    @error('address')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jam Buka</label>
                    <input type="text" name="open_hours" class="form-control" value="{{ old('open_hours') }}">
                    @error('open_hours')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Latitude</label>
                    <input type="text" name="latitude" class="form-control" value="{{ old('latitude') }}">
                    @error('latitude')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Longitude</label>
                    <input type="text" name="longitude" class="form-control" value="{{ old('longitude') }}">
                    @error('longitude')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="photo" class="form-control">
                    @error('photo')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('destinasi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
