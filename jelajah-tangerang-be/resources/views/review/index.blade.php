@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">

        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>Manajemen</strong> Review</h3>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <a href="{{ route('review.create') }}" class="btn btn-primary">
                    <i class="align-middle" data-feather="plus"></i> Tambah Review
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
                <h5 class="card-title mb-0">Daftar Ulasan Masuk</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Target Review</th>
                            <th>Reviewer</th>
                            <th>Rating</th>
                            <th class="d-none d-md-table-cell">Komentar</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    {{-- LOGIKA HYBRID --}}
                                    @if($review->article_id)
                                        <span class="badge bg-info">Artikel</span><br>
                                        <small class="fw-bold">{{ Str::limit($review->article->title ?? 'Artikel Dihapus', 30) }}</small>
                                    @elseif($review->destination_id)
                                        <span class="badge bg-success">Destinasi</span><br>
                                        <small class="fw-bold">{{ $review->destination->name ?? 'Destinasi Dihapus' }}</small>
                                    @else
                                        <span class="badge bg-secondary">Target Tidak Ada</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <i class="align-middle me-2" data-feather="user"></i>
                                        <span>{{ $review->user->name ?? 'Guest' }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    @php
                                        $bg = $review->rating >= 4 ? 'bg-success' : ($review->rating == 3 ? 'bg-warning' : 'bg-danger');
                                    @endphp
                                    <span class="badge {{ $bg }}">
                                        {{ $review->rating }} <i class="align-middle mb-1" data-feather="star" width="12" height="12"></i>
                                    </span>
                                </td>
                                <td class="d-none d-md-table-cell align-middle text-muted">
                                    <small class="d-inline-block text-truncate" style="max-width: 250px;">
                                        {{ $review->comment }}
                                    </small>
                                </td>
                                <td class="table-action text-end align-middle">
                                    <a href="{{ route('review.edit', $review->id) }}" class="text-info me-2">
                                        <i class="align-middle" data-feather="edit-2"></i>
                                    </a>
                                    <form action="{{ route('review.destroy', $review->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus review ini?')">
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
                                    <p class="mb-0 text-muted">Belum ada data ulasan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($reviews->hasPages())
                <div class="card-footer py-4">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection