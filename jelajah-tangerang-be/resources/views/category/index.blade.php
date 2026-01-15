@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">

        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>Manajemen</strong> Kategori</h3>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                    <i class="align-middle" data-feather="plus"></i> Tambah Kategori
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
                <h5 class="card-title mb-0">Daftar Kategori Destinasi & Artikel</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th style="width: 10%;">No</th>
                            <th style="width: 70%;">Nama Kategori</th>
                            <th class="text-end" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    <span class="fw-bold text-dark">{{ $category->name }}</span>
                                    <br>
                                    <small class="text-muted">Slug: {{ $category->slug }}</small>
                                </td>
                                <td class="table-action text-end align-middle">
                                    <a href="{{ route('kategori.edit', $category->id) }}" class="text-info me-2"
                                        title="Edit">
                                        <i class="align-middle" data-feather="edit-2"></i>
                                    </a>
                                    <form action="{{ route('kategori.destroy', $category->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 text-danger" title="Hapus">
                                            <i class="align-middle" data-feather="trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <i class="text-muted" data-feather="grid" style="width: 48px; height: 48px;"></i>
                                    <p class="mt-2 mb-0">Belum ada kategori data.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION CUSTOM --}}
            @if ($categories->hasPages())
                <div class="card-footer py-4">
                    {{ $categories->links('pagination.adminkit') }}
                </div>
            @endif
        </div>
    </div>
@endsection
