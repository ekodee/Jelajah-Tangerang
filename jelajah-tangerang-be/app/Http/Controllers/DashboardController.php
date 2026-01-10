<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Destination;
use App\Models\Article;
use App\Models\Review;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK KARTU (Counters)
        $totalUsers = User::count();
        $totalDestinations = Destination::count();
        $totalArticles = Article::count();
        $totalReviews = Review::count();

        // 2. DATA UNTUK GRAFIK (Destinasi per Kategori)
        // Kita hitung jumlah wisata di setiap kategori
        $categories = Category::withCount('destinations')->get();

        $chartLabels = $categories->pluck('name'); // Label: ['Pantai', 'Kuliner', dll]
        $chartData = $categories->pluck('destinations_count'); // Data: [5, 12, dll]

        // 3. AKTIVITAS TERBARU (5 Review Terakhir)
        $latestReviews = Review::with(['user', 'destination'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalUsers',
            'totalDestinations',
            'totalArticles',
            'totalReviews',
            'chartLabels',
            'chartData',
            'latestReviews'
        ));
    }
}
