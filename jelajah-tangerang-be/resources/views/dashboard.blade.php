@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3"><strong>Dashboard</strong> Analytics</h1>

        {{-- ROW 1: KARTU STATISTIK --}}
        <div class="row">
            {{-- KARTU 1: TOTAL USER --}}
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Pengguna</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="users"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $totalUsers }}</h1>
                        <div class="mb-0">
                            <span class="text-muted">Orang terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KARTU 2: TOTAL DESTINASI --}}
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Destinasi Wisata</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-success">
                                    <i class="align-middle" data-feather="map-pin"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $totalDestinations }}</h1>
                        <div class="mb-0">
                            <span class="text-muted">Lokasi aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KARTU 3: TOTAL ARTIKEL --}}
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Artikel & Berita</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-warning">
                                    <i class="align-middle" data-feather="book-open"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $totalArticles }}</h1>
                        <div class="mb-0">
                            <span class="text-muted">Dipublikasikan</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KARTU 4: TOTAL REVIEW --}}
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Ulasan Masuk</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-danger">
                                    <i class="align-middle" data-feather="message-square"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $totalReviews }}</h1>
                        <div class="mb-0">
                            <span class="text-muted">Feedback user</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW 2: CHART & TABEL --}}
        <div class="row">

            {{-- GRAFIK KATEGORI (Kiri) --}}
            <div class="col-12 col-lg-6">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Statistik Wisata per Kategori</h5>
                    </div>
                    <div class="card-body d-flex w-100">
                        <div class="align-self-center chart chart-lg">
                            <canvas id="chartjs-dashboard-bar"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABEL REVIEW TERBARU (Kanan) --}}
            <div class="col-12 col-lg-6">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ulasan Terbaru</h5>
                    </div>
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th class="d-none d-xl-table-cell">Wisata</th>
                                <th>Rating</th>
                                <th class="d-none d-md-table-cell">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestReviews as $review)
                                <tr>
                                    {{-- FIX 1: Pakai tanda tanya ganda (??) buat jaga-jaga kalau user dihapus --}}
                                    <td>{{ $review->user->name ?? 'User Telah Dihapus' }}</td>

                                    {{-- FIX 2: Cek dulu apakah destinasinya masih ada --}}
                                    <td class="d-none d-xl-table-cell">
                                        @if ($review->destination)
                                            {{ Str::limit($review->destination->name, 20) }}
                                        @else
                                            <span class="text-danger fst-italic">Wisata Dihapus</span>
                                        @endif
                                    </td>

                                    <td>
                                        <span
                                            class="badge bg-{{ $review->rating >= 4 ? 'success' : ($review->rating == 3 ? 'warning' : 'danger') }}">
                                            {{ $review->rating }} <i class="align-middle" data-feather="star"
                                                style="width:12px; height:12px;"></i>
                                        </span>
                                    </td>
                                    <td class="d-none d-md-table-cell text-muted">{{ $review->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada ulasan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- Script untuk menampilkan Grafik Chart.js --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data dari Controller Laravel
            var labels = @json($chartLabels);
            var data = @json($chartData);

            // Render Bar Chart
            new Chart(document.getElementById("chartjs-dashboard-bar"), {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Jumlah Destinasi",
                        backgroundColor: window.theme.primary,
                        borderColor: window.theme.primary,
                        hoverBackgroundColor: window.theme.primary,
                        hoverBorderColor: window.theme.primary,
                        data: data,
                        barPercentage: .75,
                        categoryPercentage: .5
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: false
                            },
                            stacked: false,
                            ticks: {
                                stepSize: 1 // Biar angkanya bulat (gak ada 1.5 wisata)
                            }
                        }],
                        xAxes: [{
                            stacked: false,
                            gridLines: {
                                color: "transparent"
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endpush
