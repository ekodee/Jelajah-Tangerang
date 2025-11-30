@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Artikel</h2>
        <a class="btn btn-primary" href="{{ route('artikel.create') }}">
            <i class="align-middle" data-feather="plus"></i> Tambah Artikel
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Thumbnail</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumb" width="60"
                                        class="rounded">
                                </td>
                                <td>
                                    <strong>{{ $article->title }}</strong><br>
                                    <small class="text-muted">{{ Str::limit($article->slug, 30) }}</small>
                                </td>
                                <td>{{ $article->user->name ?? 'Unknown' }}</td>
                                <td>
                                    @if ($article->published_at)
                                        <span class="badge bg-success">Published</span><br>
                                        <small>{{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}</small>
                                    @else
                                        <span class="badge bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('artikel.edit', $article->id) }}" class="btn btn-sm btn-info">
                                        <i class="align-middle" data-feather="edit"></i>
                                    </a>
                                    <form action="{{ route('artikel.destroy', $article->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3">Belum ada artikel.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection
