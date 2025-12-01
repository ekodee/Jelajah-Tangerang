@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Review</h2>
        <a class="btn btn-primary" href="{{ route('review.create') }}">
            <i class="align-middle" data-feather="plus"></i> Tambah Review
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Destinasi</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Reviewer</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $review->destination->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $review->rating }}/5</span>
                                </td>
                                <td>{{ Str::limit($review->comment, 50) }}</td>
                                <td>{{ $review->user->name ?? 'Unknown' }}</td>
                                <td>
                                    <a href="{{ route('review.edit', $review->id) }}" class="btn btn-sm btn-info">
                                        <i class="align-middle" data-feather="edit"></i>
                                    </a>
                                    <form action="{{ route('review.destroy', $review->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus review ini?')">
                                            <i class="align-middle" data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3">Belum ada review.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
@endsection
