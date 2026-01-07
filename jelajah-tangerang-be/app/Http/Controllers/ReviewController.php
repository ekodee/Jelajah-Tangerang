<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Destination;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        // Eager load 'user', 'destination', dan 'article' biar kenceng
        $reviews = Review::with(['user', 'destination', 'article'])->latest()->paginate(10);
        return view('review.index', compact('reviews'));
    }

    public function create()
    {
        // Kita butuh data Destinasi DAN Artikel untuk dropdown
        $destinations = Destination::select('id', 'name')->get();
        $articles = Article::select('id', 'title')->get();

        return view('review.create', compact('destinations', 'articles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating'         => 'required|integer|min:1|max:5',
            'comment'        => 'required|string',
            // Validasi: Salah satu harus diisi (Destinasi ATAU Artikel)
            'destination_id' => 'nullable|required_without:article_id|exists:destinations,id',
            'article_id'     => 'nullable|required_without:destination_id|exists:articles,id',
        ]);

        // Pastikan hanya satu yang disimpan (jika user iseng isi dua-duanya)
        // Logika: Jika Artikel dipilih, Destinasi null. Begitu sebaliknya.
        $destId = $request->article_id ? null : $request->destination_id;
        $artId  = $request->article_id ? $request->article_id : null;

        Review::create([
            'user_id'        => Auth::id(), // Admin yang login
            'destination_id' => $destId,
            'article_id'     => $artId,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
        ]);

        return redirect()->route('review.index')->with('success', 'Review berhasil ditambahkan');
    }

    public function edit(Review $review)
    {
        $destinations = Destination::select('id', 'name')->get();
        $articles = Article::select('id', 'title')->get();

        return view('review.edit', compact('review', 'destinations', 'articles'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'rating'         => 'required|integer|min:1|max:5',
            'comment'        => 'required|string',
            'destination_id' => 'nullable|required_without:article_id|exists:destinations,id',
            'article_id'     => 'nullable|required_without:destination_id|exists:articles,id',
        ]);

        $destId = $request->article_id ? null : $request->destination_id;
        $artId  = $request->article_id ? $request->article_id : null;

        $review->update([
            'destination_id' => $destId,
            'article_id'     => $artId,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
        ]);

        return redirect()->route('review.index')->with('success', 'Review berhasil diperbarui');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('review.index')->with('success', 'Review berhasil dihapus');
    }
}
