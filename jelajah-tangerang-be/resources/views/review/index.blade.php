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
                <h5 class="card-title mb-0">Ulasan Pengunjung</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Destinasi</th>
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
                                <td class="align-middle fw-bold">{{ $review->destination->name ?? '-' }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                                            style="width: 32px; height: 32px;">
                                            <i class="text-secondary" data-feather="user" width="16"></i>
                                        </div>
                                        <span>{{ $review->user->name ?? 'Guest' }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    @php
                                        $badgeClass =
                                            $review->rating >= 4
                                                ? 'bg-success'
                                                : ($review->rating >= 3
                                                    ? 'bg-warning'
                                                    : 'bg-danger');
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $review->rating }} <i class="align-middle mb-1" data-feather="star"
                                            width="12" height="12"></i>
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
                                    <i class="text-muted" data-feather="message-circle"
                                        style="width: 48px; height: 48px;"></i>
                                    <p class="mt-2 mb-0">Belum ada review masuk.</p>
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
