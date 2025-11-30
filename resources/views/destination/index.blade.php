@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>Daftar Destinasi</h2>
        <a class="btn btn-success" href="{{ route('destinasi.create') }}">Tambah Destinasi</a>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="10px">No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Alamat</th>
                        <th>Jam Buka</th>
                        <th>Foto</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($destinations as $destination)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $destination->name }}</td>
                            <td>{{ $destination->category->name }}</td>
                            <td>{{ $destination->address }}</td>
                            <td>{{ $destination->open_hours }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $destination->photo) }}" alt="" width="80">
                            </td>
                            <td>
                                <a href="{{ route('destinasi.edit', $destination->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('destinasi.destroy', $destination->id) }}" method="POST"
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
                            <td colspan="7" class="text-center">Belum ada destinasi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $destinations->links() }}
        </div>
    </div>
@endsection
