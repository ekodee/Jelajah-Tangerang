@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">

        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>Manajemen</strong> Destinasi</h3>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <a href="{{ route('destinasi.create') }}" class="btn btn-primary">
                    <i class="align-middle" data-feather="plus"></i> Tambah Destinasi
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-message">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Lokasi Wisata</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Destinasi</th>
                            <th>Kategori</th>
                            <th class="d-none d-md-table-cell">Alamat</th>
                            <th>Jam Buka</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($destinations as $destination)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        {{-- LOGIC HYBRID IMAGE --}}
                                        @php
                                            $imageSrc = Str::startsWith($destination->photo, 'http')
                                                ? $destination->photo
                                                : asset('storage/' . $destination->photo);
                                        @endphp

                                        <img src="{{ $imageSrc }}" class="rounded me-2" width="60" height="40"
                                            style="object-fit: cover;" alt="Foto">

                                        <span class="fw-bold">{{ $destination->name }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-info">{{ $destination->category->name ?? 'Umum' }}</span>
                                </td>
                                <td class="d-none d-md-table-cell align-middle text-muted">
                                    <small>{{ Str::limit($destination->address, 35) }}</small>
                                </td>
                                <td class="align-middle">
                                    <i class="align-middle me-1 text-muted" data-feather="clock" width="14"></i>
                                    {{ $destination->open_hours }}
                                </td>
                                <td class="table-action text-end align-middle">
                                    <a href="{{ route('destinasi.edit', $destination->id) }}" class="text-info me-2">
                                        <i class="align-middle" data-feather="edit-2"></i>
                                    </a>
                                    <form action="{{ route('destinasi.destroy', $destination->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus destinasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 text-danger">
                                            <i class="align-middle" data-feather="trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="text-muted" data-feather="map-pin" style="width: 48px; height: 48px;"></i>
                                    <p class="mt-2 mb-0">Belum ada destinasi wisata.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($destinations->hasPages())
                <div class="card-footer py-4">
                    {{ $destinations->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
