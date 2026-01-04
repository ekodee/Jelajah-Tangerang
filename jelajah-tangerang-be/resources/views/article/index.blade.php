@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">

    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>Manajemen</strong> Artikel</h3>
        </div>
        <div class="col-auto ms-auto text-end mt-n1">
            <a href="{{ route('artikel.create') }}" class="btn btn-primary">
                <i class="align-middle" data-feather="plus"></i> Tambah Artikel
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-message">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card flex-fill">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Artikel Jelajah Tangerang</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Artikel</th>
                        <th>Penulis</th>
                        <th>Status</th>
                        <th class="d-none d-md-table-cell">Tanggal</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" class="rounded me-2" width="48" height="48" style="object-fit: cover;" alt="Thumb">
                                    <div>
                                        <div class="fw-bold">{{ Str::limit($article->title, 40) }}</div>
                                        <small class="text-muted">{{ Str::limit($article->slug, 20) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="badge bg-light text-dark border">{{ $article->user->name ?? 'Unknown' }}</span>
                            </td>
                            <td class="align-middle">
                                @if ($article->published_at)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell align-middle">
                                {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d M Y') : '-' }}
                            </td>
                            <td class="table-action text-end align-middle">
                                <a href="{{ route('artikel.edit', $article->id) }}" class="text-info me-2" title="Edit">
                                    <i class="align-middle" data-feather="edit-2"></i>
                                </a>
                                <form action="{{ route('artikel.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus artikel ini?')">
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
                            <td colspan="6" class="text-center py-5">
                                <i class="text-muted" data-feather="file-text" style="width: 48px; height: 48px;"></i>
                                <p class="mt-2 mb-0">Belum ada artikel yang dibuat.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($articles->hasPages())
            <div class="card-footer py-4">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection